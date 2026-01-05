import React, { useState, useCallback } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Label } from '../../../components/ui/label';
import { Textarea } from '../../../components/ui/textarea';
import { Badge } from '../../../components/ui/badge';
import { Switch } from '../../../components/ui/switch';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogFooter,
} from '../../../components/ui/dialog';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '../../../components/ui/alert-dialog';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
} from '../../../components/ui/sheet';
import {
    DndContext,
    closestCenter,
    KeyboardSensor,
    PointerSensor,
    useSensor,
    useSensors,
    DragOverlay,
} from '@dnd-kit/core';
import {
    arrayMove,
    SortableContext,
    sortableKeyboardCoordinates,
    verticalListSortingStrategy,
    useSortable,
} from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import {
    ArrowLeft,
    Plus,
    GripVertical,
    ChevronRight,
    Play,
    FileText,
    HelpCircle,
    ClipboardCheck,
    Pencil,
    Trash2,
    Check,
    Loader2,
    Eye,
    EyeOff,
    Video,
    BookOpen,
} from 'lucide-react';
import axios from 'axios';

// Lesson type configurations
const LESSON_TYPES = {
    video: { label: 'Video', icon: Play, color: 'bg-blue-100 text-blue-600', borderColor: 'border-blue-200' },
    text: { label: 'Text', icon: FileText, color: 'bg-green-100 text-green-600', borderColor: 'border-green-200' },
    quiz: { label: 'Quiz', icon: HelpCircle, color: 'bg-amber-100 text-amber-600', borderColor: 'border-amber-200' },
    assignment: { label: 'Assignment', icon: ClipboardCheck, color: 'bg-purple-100 text-purple-600', borderColor: 'border-purple-200' },
};

// Sortable Lesson Item
function SortableLessonItem({ lesson, onEdit, onDelete }) {
    const { attributes, listeners, setNodeRef, transform, transition, isDragging } = useSortable({ id: lesson.id });

    const style = {
        transform: CSS.Transform.toString(transform),
        transition,
        opacity: isDragging ? 0.5 : 1,
    };

    const TypeIcon = LESSON_TYPES[lesson.type]?.icon || FileText;
    const typeConfig = LESSON_TYPES[lesson.type] || LESSON_TYPES.text;

    return (
        <div
            ref={setNodeRef}
            style={style}
            className={`group flex items-center gap-3 p-3 bg-white border rounded-lg hover:shadow-sm transition-all ${isDragging ? 'shadow-lg ring-2 ring-green-500' : ''}`}
        >
            <button {...attributes} {...listeners} className="cursor-grab text-gray-400 hover:text-gray-600 touch-none">
                <GripVertical className="h-4 w-4" />
            </button>

            <div className={`flex items-center justify-center w-8 h-8 rounded-lg ${typeConfig.color}`}>
                <TypeIcon className="h-4 w-4" />
            </div>

            <div className="flex-1 min-w-0">
                <p className="text-sm font-medium text-gray-900 truncate">{lesson.title}</p>
                <div className="flex items-center gap-2 mt-0.5">
                    <span className="text-xs text-gray-500">{typeConfig.label}</span>
                    {lesson.is_free && (
                        <Badge variant="secondary" className="text-xs bg-green-50 text-green-700 border-green-200">
                            Free Preview
                        </Badge>
                    )}
                    {!lesson.is_published && (
                        <Badge variant="secondary" className="text-xs bg-gray-100 text-gray-600">
                            Draft
                        </Badge>
                    )}
                </div>
            </div>

            <div className="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <Button variant="ghost" size="sm" className="h-8 w-8 p-0" onClick={() => onEdit(lesson)}>
                    <Pencil className="h-4 w-4 text-gray-500" />
                </Button>
                <Button variant="ghost" size="sm" className="h-8 w-8 p-0 hover:text-red-600" onClick={() => onDelete(lesson)}>
                    <Trash2 className="h-4 w-4" />
                </Button>
            </div>
        </div>
    );
}

// Sortable Module Card
function SortableModuleCard({ module, index, onEdit, onDelete, onAddLesson, onEditLesson, onDeleteLesson, onLessonsReorder }) {
    const [isExpanded, setIsExpanded] = useState(true);
    const { attributes, listeners, setNodeRef, transform, transition, isDragging } = useSortable({ id: module.id });

    const style = {
        transform: CSS.Transform.toString(transform),
        transition,
        opacity: isDragging ? 0.5 : 1,
    };

    const sensors = useSensors(
        useSensor(PointerSensor, { activationConstraint: { distance: 8 } }),
        useSensor(KeyboardSensor, { coordinateGetter: sortableKeyboardCoordinates })
    );

    const handleLessonDragEnd = (event) => {
        const { active, over } = event;
        if (active.id !== over?.id) {
            const oldIndex = module.lessons.findIndex((l) => l.id === active.id);
            const newIndex = module.lessons.findIndex((l) => l.id === over.id);
            const newLessons = arrayMove(module.lessons, oldIndex, newIndex);
            onLessonsReorder(module.id, newLessons);
        }
    };

    return (
        <div
            ref={setNodeRef}
            style={style}
            className={`bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden ${isDragging ? 'shadow-xl ring-2 ring-green-500' : ''}`}
        >
            {/* Module Header */}
            <div className="flex items-center gap-3 px-4 py-3 bg-gray-50 border-b border-gray-200">
                <button {...attributes} {...listeners} className="cursor-grab text-gray-400 hover:text-gray-600 touch-none">
                    <GripVertical className="h-5 w-5" />
                </button>

                <button
                    onClick={() => setIsExpanded(!isExpanded)}
                    className="p-1 hover:bg-gray-200 rounded transition-colors"
                >
                    <ChevronRight className={`h-5 w-5 text-gray-500 transition-transform ${isExpanded ? 'rotate-90' : ''}`} />
                </button>

                <div className="flex-1 min-w-0">
                    <div className="flex items-center gap-2">
                        <span className="text-xs font-medium text-gray-500 uppercase tracking-wide">Section {index + 1}</span>
                        {!module.is_published && (
                            <Badge variant="secondary" className="text-xs">Draft</Badge>
                        )}
                    </div>
                    <h3 className="font-semibold text-gray-900 truncate">{module.title}</h3>
                </div>

                <div className="flex items-center gap-2">
                    <span className="text-sm text-gray-500">{module.lessons?.length || 0} lessons</span>
                    <Button variant="ghost" size="sm" className="h-8 w-8 p-0" onClick={() => onEdit(module)}>
                        <Pencil className="h-4 w-4 text-gray-500" />
                    </Button>
                    <Button variant="ghost" size="sm" className="h-8 w-8 p-0 hover:text-red-600" onClick={() => onDelete(module)}>
                        <Trash2 className="h-4 w-4" />
                    </Button>
                </div>
            </div>

            {/* Lessons List */}
            {isExpanded && (
                <div className="p-4">
                    {module.lessons?.length > 0 ? (
                        <DndContext sensors={sensors} collisionDetection={closestCenter} onDragEnd={handleLessonDragEnd}>
                            <SortableContext items={module.lessons.map((l) => l.id)} strategy={verticalListSortingStrategy}>
                                <div className="space-y-2">
                                    {module.lessons.map((lesson) => (
                                        <SortableLessonItem
                                            key={lesson.id}
                                            lesson={lesson}
                                            onEdit={onEditLesson}
                                            onDelete={onDeleteLesson}
                                        />
                                    ))}
                                </div>
                            </SortableContext>
                        </DndContext>
                    ) : (
                        <div className="text-center py-6 text-gray-500">
                            <BookOpen className="h-8 w-8 mx-auto text-gray-300 mb-2" />
                            <p className="text-sm">No lessons yet. Add your first lesson below.</p>
                        </div>
                    )}

                    {/* Add Lesson Buttons */}
                    <div className="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                        {Object.entries(LESSON_TYPES).map(([type, config]) => {
                            const Icon = config.icon;
                            return (
                                <Button
                                    key={type}
                                    variant="outline"
                                    size="sm"
                                    className="text-gray-600"
                                    onClick={() => onAddLesson(module, type)}
                                >
                                    <Plus className="h-4 w-4 mr-1" />
                                    <Icon className={`h-4 w-4 mr-1 ${config.color.split(' ')[1]}`} />
                                    {config.label}
                                </Button>
                            );
                        })}
                    </div>
                </div>
            )}
        </div>
    );
}

// Lesson Editor Sheet
function LessonEditorSheet({ lesson, module, open, onClose, onSave, onDelete, saving }) {
    const [form, setForm] = useState({
        id: lesson?.id || null,
        title: lesson?.title || '',
        type: lesson?.type || 'video',
        content: lesson?.content || '',
        video_url: lesson?.video_url || '',
        is_free: lesson?.is_free || false,
        is_published: lesson?.is_published || false,
    });

    React.useEffect(() => {
        if (lesson) {
            setForm({
                id: lesson.id,
                title: lesson.title || '',
                type: lesson.type || 'video',
                content: lesson.content || '',
                video_url: lesson.video_url || '',
                is_free: lesson.is_free || false,
                is_published: lesson.is_published || false,
            });
        }
    }, [lesson]);

    const getVideoEmbedUrl = (url) => {
        if (!url) return null;
        const youtubeMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/);
        if (youtubeMatch) return `https://www.youtube.com/embed/${youtubeMatch[1]}`;
        const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
        if (vimeoMatch) return `https://player.vimeo.com/video/${vimeoMatch[1]}`;
        return null;
    };

    const embedUrl = getVideoEmbedUrl(form.video_url);
    const typeConfig = LESSON_TYPES[form.type] || LESSON_TYPES.text;
    const TypeIcon = typeConfig.icon;

    return (
        <Sheet open={open} onOpenChange={onClose}>
            <SheetContent className="w-full sm:max-w-xl flex flex-col p-0">
                <SheetHeader className="px-6 py-4 border-b">
                    <SheetTitle>Edit Lesson</SheetTitle>
                    <p className="text-sm text-gray-500">{module?.title}</p>
                </SheetHeader>

                <div className="flex-1 overflow-y-auto p-6 space-y-6">
                    {/* Title */}
                    <div className="space-y-2">
                        <Label htmlFor="title">Title</Label>
                        <Input
                            id="title"
                            value={form.title}
                            onChange={(e) => setForm({ ...form, title: e.target.value })}
                            placeholder="Lesson title"
                        />
                    </div>

                    {/* Type Indicator */}
                    <div className={`flex items-center gap-3 p-4 rounded-lg ${typeConfig.color.split(' ')[0]} border ${typeConfig.borderColor}`}>
                        <div className={`flex items-center justify-center w-10 h-10 rounded-lg bg-white`}>
                            <TypeIcon className={`h-5 w-5 ${typeConfig.color.split(' ')[1]}`} />
                        </div>
                        <div>
                            <p className="text-sm font-medium text-gray-900">{typeConfig.label} Lesson</p>
                            <p className="text-xs text-gray-500">Type cannot be changed after creation</p>
                        </div>
                    </div>

                    {/* Video URL */}
                    {form.type === 'video' && (
                        <div className="space-y-2">
                            <Label htmlFor="video_url">Video URL</Label>
                            <Input
                                id="video_url"
                                value={form.video_url}
                                onChange={(e) => setForm({ ...form, video_url: e.target.value })}
                                placeholder="https://youtube.com/watch?v=... or https://vimeo.com/..."
                            />
                            <p className="text-xs text-gray-500">Paste a YouTube or Vimeo URL</p>

                            {embedUrl && (
                                <div className="mt-4">
                                    <Label className="mb-2 block">Preview</Label>
                                    <div className="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                        <iframe
                                            src={embedUrl}
                                            className="w-full h-full"
                                            frameBorder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowFullScreen
                                        />
                                    </div>
                                </div>
                            )}
                        </div>
                    )}

                    {/* Content */}
                    <div className="space-y-2">
                        <Label htmlFor="content">
                            {form.type === 'video' ? 'Description (optional)' : 'Content'}
                        </Label>
                        <Textarea
                            id="content"
                            value={form.content}
                            onChange={(e) => setForm({ ...form, content: e.target.value })}
                            rows={8}
                            placeholder={
                                form.type === 'video' ? 'Add a description for this video lesson...' :
                                form.type === 'quiz' ? 'Add instructions for students before they take the quiz...' :
                                form.type === 'assignment' ? 'Describe the assignment requirements...' :
                                'Write your lesson content here...'
                            }
                        />
                        <p className="text-xs text-gray-500">Supports basic Markdown formatting</p>
                    </div>

                    {/* Quiz Info */}
                    {form.type === 'quiz' && (
                        <div className="bg-amber-50 border border-amber-200 rounded-lg p-4">
                            <div className="flex items-start gap-3">
                                <HelpCircle className="h-5 w-5 text-amber-600 mt-0.5" />
                                <div>
                                    <h4 className="text-sm font-medium text-amber-800">Quiz Questions</h4>
                                    <p className="text-sm text-amber-700 mt-1">
                                        After saving, you can add quiz questions from the Quizzes section in the teacher panel.
                                    </p>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* Assignment Info */}
                    {form.type === 'assignment' && (
                        <div className="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <div className="flex items-start gap-3">
                                <ClipboardCheck className="h-5 w-5 text-purple-600 mt-0.5" />
                                <div>
                                    <h4 className="text-sm font-medium text-purple-800">Assignment Details</h4>
                                    <p className="text-sm text-purple-700 mt-1">
                                        Students will be able to submit their work through the course page.
                                    </p>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* Settings */}
                    <div className="space-y-4 pt-4 border-t">
                        <h3 className="text-sm font-medium text-gray-900">Settings</h3>

                        <div className="flex items-center justify-between">
                            <div>
                                <Label htmlFor="is_free" className="text-sm font-medium">Free Preview</Label>
                                <p className="text-xs text-gray-500">Allow non-enrolled students to view this lesson</p>
                            </div>
                            <Switch
                                id="is_free"
                                checked={form.is_free}
                                onCheckedChange={(checked) => setForm({ ...form, is_free: checked })}
                            />
                        </div>

                        <div className="flex items-center justify-between">
                            <div>
                                <Label htmlFor="is_published" className="text-sm font-medium">Published</Label>
                                <p className="text-xs text-gray-500">Make this lesson visible to enrolled students</p>
                            </div>
                            <Switch
                                id="is_published"
                                checked={form.is_published}
                                onCheckedChange={(checked) => setForm({ ...form, is_published: checked })}
                            />
                        </div>
                    </div>
                </div>

                {/* Footer */}
                <div className="flex items-center justify-between px-6 py-4 border-t bg-gray-50">
                    <Button variant="ghost" className="text-red-600 hover:text-red-700 hover:bg-red-50" onClick={() => onDelete(lesson)}>
                        <Trash2 className="h-4 w-4 mr-2" />
                        Delete
                    </Button>
                    <div className="flex items-center gap-2">
                        <Button variant="outline" onClick={onClose}>Cancel</Button>
                        <Button onClick={() => onSave(form)} disabled={saving} className="bg-green-600 hover:bg-green-700">
                            {saving ? <Loader2 className="h-4 w-4 mr-2 animate-spin" /> : <Check className="h-4 w-4 mr-2" />}
                            Save Changes
                        </Button>
                    </div>
                </div>
            </SheetContent>
        </Sheet>
    );
}

// Main Curriculum Builder Component
export default function CurriculumBuilder({ course, modules: initialModules }) {
    const [modules, setModules] = useState(initialModules || []);
    const [saving, setSaving] = useState(false);
    const [lastSaved, setLastSaved] = useState(false);

    // Modal states
    const [showAddModuleDialog, setShowAddModuleDialog] = useState(false);
    const [editingModule, setEditingModule] = useState(null);
    const [moduleForm, setModuleForm] = useState({ title: '', description: '' });

    // Lesson states
    const [showAddLessonDialog, setShowAddLessonDialog] = useState(false);
    const [addingLessonToModule, setAddingLessonToModule] = useState(null);
    const [lessonForm, setLessonForm] = useState({ title: '', type: 'video' });
    const [editingLesson, setEditingLesson] = useState(null);
    const [editingLessonModule, setEditingLessonModule] = useState(null);

    // Delete confirmation
    const [deleteConfirmation, setDeleteConfirmation] = useState(null);

    const sensors = useSensors(
        useSensor(PointerSensor, { activationConstraint: { distance: 8 } }),
        useSensor(KeyboardSensor, { coordinateGetter: sortableKeyboardCoordinates })
    );

    const showSavedIndicator = () => {
        setLastSaved(true);
        setTimeout(() => setLastSaved(false), 2000);
    };

    // Module operations
    const handleAddModule = () => {
        setModuleForm({ title: '', description: '' });
        setEditingModule(null);
        setShowAddModuleDialog(true);
    };

    const handleEditModule = (module) => {
        setModuleForm({ title: module.title, description: module.description || '' });
        setEditingModule(module);
        setShowAddModuleDialog(true);
    };

    const handleSaveModule = async () => {
        setSaving(true);
        try {
            if (editingModule) {
                const response = await axios.put(`/api/modules/${editingModule.id}`, moduleForm);
                setModules(modules.map((m) => (m.id === editingModule.id ? { ...m, ...response.data } : m)));
            } else {
                const response = await axios.post(`/api/courses/${course.slug}/modules`, moduleForm);
                setModules([...modules, { ...response.data, lessons: [] }]);
            }
            setShowAddModuleDialog(false);
            showSavedIndicator();
        } catch (error) {
            console.error('Failed to save module:', error);
        } finally {
            setSaving(false);
        }
    };

    const handleDeleteModule = (module) => {
        setDeleteConfirmation({
            type: 'section',
            title: module.title,
            message: 'This will also delete all lessons in this section.',
            onConfirm: async () => {
                setSaving(true);
                try {
                    await axios.delete(`/api/modules/${module.id}`);
                    setModules(modules.filter((m) => m.id !== module.id));
                    showSavedIndicator();
                } catch (error) {
                    console.error('Failed to delete module:', error);
                } finally {
                    setSaving(false);
                    setDeleteConfirmation(null);
                }
            },
        });
    };

    // Lesson operations
    const handleAddLesson = (module, type) => {
        setAddingLessonToModule(module);
        setLessonForm({ title: '', type });
        setShowAddLessonDialog(true);
    };

    const handleCreateLesson = async () => {
        setSaving(true);
        try {
            const response = await axios.post(`/api/modules/${addingLessonToModule.id}/lessons`, lessonForm);
            setModules(modules.map((m) => {
                if (m.id === addingLessonToModule.id) {
                    return { ...m, lessons: [...(m.lessons || []), response.data] };
                }
                return m;
            }));
            setShowAddLessonDialog(false);
            showSavedIndicator();
        } catch (error) {
            console.error('Failed to create lesson:', error);
        } finally {
            setSaving(false);
        }
    };

    const handleEditLesson = (lesson) => {
        const module = modules.find((m) => m.lessons?.some((l) => l.id === lesson.id));
        setEditingLesson(lesson);
        setEditingLessonModule(module);
    };

    const handleSaveLesson = async (lessonData) => {
        setSaving(true);
        try {
            const response = await axios.put(`/api/lessons/${lessonData.id}`, lessonData);
            setModules(modules.map((m) => ({
                ...m,
                lessons: m.lessons?.map((l) => (l.id === lessonData.id ? response.data : l)),
            })));
            setEditingLesson(null);
            showSavedIndicator();
        } catch (error) {
            console.error('Failed to save lesson:', error);
        } finally {
            setSaving(false);
        }
    };

    const handleDeleteLesson = (lesson) => {
        setEditingLesson(null);
        setDeleteConfirmation({
            type: 'lesson',
            title: lesson.title,
            message: 'This action cannot be undone.',
            onConfirm: async () => {
                setSaving(true);
                try {
                    await axios.delete(`/api/lessons/${lesson.id}`);
                    setModules(modules.map((m) => ({
                        ...m,
                        lessons: m.lessons?.filter((l) => l.id !== lesson.id),
                    })));
                    showSavedIndicator();
                } catch (error) {
                    console.error('Failed to delete lesson:', error);
                } finally {
                    setSaving(false);
                    setDeleteConfirmation(null);
                }
            },
        });
    };

    // Drag and drop handlers
    const handleModuleDragEnd = async (event) => {
        const { active, over } = event;
        if (active.id !== over?.id) {
            const oldIndex = modules.findIndex((m) => m.id === active.id);
            const newIndex = modules.findIndex((m) => m.id === over.id);
            const newModules = arrayMove(modules, oldIndex, newIndex);
            setModules(newModules);
            await saveOrder(newModules);
        }
    };

    const handleLessonsReorder = async (moduleId, newLessons) => {
        const newModules = modules.map((m) => (m.id === moduleId ? { ...m, lessons: newLessons } : m));
        setModules(newModules);
        await saveOrder(newModules);
    };

    const saveOrder = async (modulesToSave) => {
        setSaving(true);
        try {
            const orderData = modulesToSave.map((module, moduleIndex) => ({
                id: module.id,
                order: moduleIndex + 1,
                lessons: module.lessons?.map((lesson, lessonIndex) => ({
                    id: lesson.id,
                    order: lessonIndex + 1,
                })) || [],
            }));
            await axios.post(`/api/courses/${course.slug}/curriculum/reorder`, { modules: orderData });
            showSavedIndicator();
        } catch (error) {
            console.error('Failed to save order:', error);
        } finally {
            setSaving(false);
        }
    };

    return (
        <TeacherLayout>
            <Head title={`Curriculum - ${course.title}`} />

            {/* Header */}
            <div className="bg-white border-b -mx-4 lg:-mx-8 px-4 lg:px-8 -mt-4 lg:-mt-8 mb-8">
                <div className="flex items-center justify-between h-16 max-w-4xl mx-auto">
                    <div className="flex items-center gap-4">
                        <Link href={route('teacher.courses')} className="p-2 hover:bg-gray-100 rounded-full transition-colors">
                            <ArrowLeft className="h-5 w-5 text-gray-500" />
                        </Link>
                        <div>
                            <h1 className="text-lg font-semibold text-gray-900">Curriculum</h1>
                            <p className="text-sm text-gray-500">{course.title}</p>
                        </div>
                    </div>
                    <div className="flex items-center gap-3">
                        {saving && (
                            <span className="flex items-center text-sm text-gray-500">
                                <Loader2 className="h-4 w-4 mr-2 animate-spin" />
                                Saving...
                            </span>
                        )}
                        {lastSaved && !saving && (
                            <span className="flex items-center text-sm text-green-600">
                                <Check className="h-4 w-4 mr-1" />
                                Saved
                            </span>
                        )}
                    </div>
                </div>
            </div>

            {/* Content */}
            <div className="max-w-4xl mx-auto">
                {/* Add Section Button */}
                <button
                    onClick={handleAddModule}
                    className="w-full mb-6 py-4 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 hover:border-green-400 hover:text-green-600 transition-all flex items-center justify-center gap-2 group"
                >
                    <Plus className="h-5 w-5 group-hover:scale-110 transition-transform" />
                    <span className="font-medium">Add Section</span>
                </button>

                {/* Modules List */}
                {modules.length > 0 ? (
                    <DndContext sensors={sensors} collisionDetection={closestCenter} onDragEnd={handleModuleDragEnd}>
                        <SortableContext items={modules.map((m) => m.id)} strategy={verticalListSortingStrategy}>
                            <div className="space-y-4">
                                {modules.map((module, index) => (
                                    <SortableModuleCard
                                        key={module.id}
                                        module={module}
                                        index={index}
                                        onEdit={handleEditModule}
                                        onDelete={handleDeleteModule}
                                        onAddLesson={handleAddLesson}
                                        onEditLesson={handleEditLesson}
                                        onDeleteLesson={handleDeleteLesson}
                                        onLessonsReorder={handleLessonsReorder}
                                    />
                                ))}
                            </div>
                        </SortableContext>
                    </DndContext>
                ) : (
                    <div className="text-center py-16">
                        <BookOpen className="h-12 w-12 mx-auto text-gray-300 mb-4" />
                        <h3 className="text-lg font-medium text-gray-900 mb-1">No sections yet</h3>
                        <p className="text-gray-500 mb-4">Get started by adding your first section.</p>
                        <Button onClick={handleAddModule} className="bg-green-600 hover:bg-green-700">
                            <Plus className="h-4 w-4 mr-2" />
                            Add First Section
                        </Button>
                    </div>
                )}
            </div>

            {/* Add/Edit Module Dialog */}
            <Dialog open={showAddModuleDialog} onOpenChange={setShowAddModuleDialog}>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>{editingModule ? 'Edit Section' : 'Add Section'}</DialogTitle>
                    </DialogHeader>
                    <div className="space-y-4 py-4">
                        <div className="space-y-2">
                            <Label htmlFor="module-title">Title</Label>
                            <Input
                                id="module-title"
                                value={moduleForm.title}
                                onChange={(e) => setModuleForm({ ...moduleForm, title: e.target.value })}
                                placeholder="e.g., Introduction"
                            />
                        </div>
                        <div className="space-y-2">
                            <Label htmlFor="module-description">Description (optional)</Label>
                            <Textarea
                                id="module-description"
                                value={moduleForm.description}
                                onChange={(e) => setModuleForm({ ...moduleForm, description: e.target.value })}
                                placeholder="What will students learn in this section?"
                                rows={3}
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <Button variant="outline" onClick={() => setShowAddModuleDialog(false)}>Cancel</Button>
                        <Button onClick={handleSaveModule} disabled={saving || !moduleForm.title} className="bg-green-600 hover:bg-green-700">
                            {saving ? <Loader2 className="h-4 w-4 mr-2 animate-spin" /> : null}
                            {editingModule ? 'Save Changes' : 'Add Section'}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            {/* Add Lesson Dialog */}
            <Dialog open={showAddLessonDialog} onOpenChange={setShowAddLessonDialog}>
                <DialogContent>
                    <DialogHeader>
                        <div className="flex items-center gap-3">
                            {lessonForm.type && (
                                <div className={`flex items-center justify-center w-10 h-10 rounded-lg ${LESSON_TYPES[lessonForm.type]?.color}`}>
                                    {React.createElement(LESSON_TYPES[lessonForm.type]?.icon, { className: 'h-5 w-5' })}
                                </div>
                            )}
                            <div>
                                <DialogTitle>Add {LESSON_TYPES[lessonForm.type]?.label} Lesson</DialogTitle>
                                <p className="text-sm text-gray-500">{addingLessonToModule?.title}</p>
                            </div>
                        </div>
                    </DialogHeader>
                    <div className="py-4">
                        <div className="space-y-2">
                            <Label htmlFor="lesson-title">Title</Label>
                            <Input
                                id="lesson-title"
                                value={lessonForm.title}
                                onChange={(e) => setLessonForm({ ...lessonForm, title: e.target.value })}
                                placeholder="e.g., Welcome to the Course"
                                autoFocus
                            />
                        </div>
                    </div>
                    <DialogFooter>
                        <Button variant="outline" onClick={() => setShowAddLessonDialog(false)}>Cancel</Button>
                        <Button onClick={handleCreateLesson} disabled={saving || !lessonForm.title} className="bg-green-600 hover:bg-green-700">
                            {saving ? <Loader2 className="h-4 w-4 mr-2 animate-spin" /> : null}
                            Add Lesson
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            {/* Lesson Editor Sheet */}
            <LessonEditorSheet
                lesson={editingLesson}
                module={editingLessonModule}
                open={!!editingLesson}
                onClose={() => setEditingLesson(null)}
                onSave={handleSaveLesson}
                onDelete={handleDeleteLesson}
                saving={saving}
            />

            {/* Delete Confirmation */}
            <AlertDialog open={!!deleteConfirmation} onOpenChange={() => setDeleteConfirmation(null)}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Delete {deleteConfirmation?.type}?</AlertDialogTitle>
                        <AlertDialogDescription>
                            Are you sure you want to delete "{deleteConfirmation?.title}"? {deleteConfirmation?.message}
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction
                            onClick={deleteConfirmation?.onConfirm}
                            className="bg-red-600 hover:bg-red-700"
                        >
                            Delete
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </TeacherLayout>
    );
}
