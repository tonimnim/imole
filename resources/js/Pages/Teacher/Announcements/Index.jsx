import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from '../../../components/ui/card';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Label } from '../../../components/ui/label';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger, DialogFooter } from '../../../components/ui/dialog';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '../../../components/ui/alert-dialog';
import { Megaphone, Plus, Edit2, Trash2, Send, FileText, Clock } from 'lucide-react';

export default function AnnouncementsIndex({ announcements, stats, courses }) {
    const [isCreateOpen, setIsCreateOpen] = useState(false);
    const [isEditOpen, setIsEditOpen] = useState(false);
    const [deleteId, setDeleteId] = useState(null);
    const [editingAnnouncement, setEditingAnnouncement] = useState(null);
    const [form, setForm] = useState({
        title: '',
        content: '',
        course_id: '',
        is_published: false,
    });
    const [processing, setProcessing] = useState(false);

    const resetForm = () => {
        setForm({ title: '', content: '', course_id: '', is_published: false });
    };

    const handleCreate = (e) => {
        e.preventDefault();
        setProcessing(true);
        router.post(route('teacher.announcements.store'), form, {
            onSuccess: () => {
                setIsCreateOpen(false);
                resetForm();
            },
            onFinish: () => setProcessing(false),
        });
    };

    const openEdit = (announcement) => {
        setEditingAnnouncement(announcement);
        setForm({
            title: announcement.title,
            content: announcement.content,
            course_id: announcement.course?.id || '',
            is_published: announcement.isPublished,
        });
        setIsEditOpen(true);
    };

    const handleUpdate = (e) => {
        e.preventDefault();
        setProcessing(true);
        router.put(route('teacher.announcements.update', editingAnnouncement.id), form, {
            onSuccess: () => {
                setIsEditOpen(false);
                setEditingAnnouncement(null);
                resetForm();
            },
            onFinish: () => setProcessing(false),
        });
    };

    const handleDelete = () => {
        router.delete(route('teacher.announcements.destroy', deleteId), {
            onSuccess: () => setDeleteId(null),
        });
    };

    const AnnouncementForm = ({ onSubmit, submitLabel }) => (
        <form onSubmit={onSubmit} className="space-y-4">
            <div>
                <Label htmlFor="title">Title</Label>
                <Input
                    id="title"
                    value={form.title}
                    onChange={(e) => setForm({ ...form, title: e.target.value })}
                    placeholder="Announcement title..."
                    required
                />
            </div>
            <div>
                <Label htmlFor="course_id">Target Course (optional)</Label>
                <select
                    id="course_id"
                    value={form.course_id}
                    onChange={(e) => setForm({ ...form, course_id: e.target.value })}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                >
                    <option value="">All Students</option>
                    {courses.map((course) => (
                        <option key={course.id} value={course.id}>{course.title}</option>
                    ))}
                </select>
                <p className="text-xs text-gray-500 mt-1">Leave empty to send to all your students</p>
            </div>
            <div>
                <Label htmlFor="content">Content</Label>
                <textarea
                    id="content"
                    value={form.content}
                    onChange={(e) => setForm({ ...form, content: e.target.value })}
                    placeholder="Write your announcement..."
                    rows={5}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none"
                    required
                />
            </div>
            <div className="flex items-center gap-2">
                <input
                    type="checkbox"
                    id="is_published"
                    checked={form.is_published}
                    onChange={(e) => setForm({ ...form, is_published: e.target.checked })}
                    className="rounded border-gray-300"
                />
                <Label htmlFor="is_published" className="font-normal">Publish immediately</Label>
            </div>
            <DialogFooter>
                <Button type="submit" disabled={processing} className="bg-green-600 hover:bg-green-700">
                    <Send className="h-4 w-4 mr-2" />
                    {submitLabel}
                </Button>
            </DialogFooter>
        </form>
    );

    return (
        <TeacherLayout>
            <Head title="Announcements" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Announcements</h1>
                    <p className="mt-1 text-gray-500">Communicate with your students.</p>
                </div>
                <Dialog open={isCreateOpen} onOpenChange={(open) => { setIsCreateOpen(open); if (!open) resetForm(); }}>
                    <DialogTrigger asChild>
                        <Button className="bg-green-600 hover:bg-green-700">
                            <Plus className="h-4 w-4 mr-2" />
                            New Announcement
                        </Button>
                    </DialogTrigger>
                    <DialogContent className="sm:max-w-[500px]">
                        <DialogHeader>
                            <DialogTitle>Create Announcement</DialogTitle>
                        </DialogHeader>
                        <AnnouncementForm onSubmit={handleCreate} submitLabel="Create Announcement" />
                    </DialogContent>
                </Dialog>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <Megaphone className="h-4 w-4" />
                            Total
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{stats.total}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <Send className="h-4 w-4" />
                            Published
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">{stats.published}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <FileText className="h-4 w-4" />
                            Drafts
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-gray-600">{stats.drafts}</div>
                    </CardContent>
                </Card>
            </div>

            {/* Announcements List */}
            <div className="space-y-4">
                {announcements.data.length > 0 ? announcements.data.map((announcement) => (
                    <Card key={announcement.id} className="hover:shadow-md transition-shadow">
                        <CardContent className="p-6">
                            <div className="flex items-start justify-between">
                                <div className="flex-1 min-w-0">
                                    <div className="flex items-center gap-3 mb-2">
                                        <h3 className="font-semibold text-gray-900 text-lg">{announcement.title}</h3>
                                        <Badge variant={announcement.isPublished ? 'success' : 'secondary'}>
                                            {announcement.isPublished ? 'Published' : 'Draft'}
                                        </Badge>
                                        {announcement.course && (
                                            <Badge variant="outline">{announcement.course.title}</Badge>
                                        )}
                                    </div>
                                    <p className="text-gray-600 mb-3 line-clamp-2">{announcement.content}</p>
                                    <div className="flex items-center gap-4 text-sm text-gray-500">
                                        <span className="flex items-center gap-1">
                                            <Clock className="h-4 w-4" />
                                            {announcement.createdAt}
                                        </span>
                                        {announcement.publishedAt && (
                                            <span>Published: {announcement.publishedAt}</span>
                                        )}
                                    </div>
                                </div>

                                <div className="flex items-center gap-2 shrink-0 ml-4">
                                    <Button variant="ghost" size="sm" onClick={() => openEdit(announcement)}>
                                        <Edit2 className="h-4 w-4" />
                                    </Button>
                                    <Button variant="ghost" size="sm" className="text-red-600 hover:text-red-700" onClick={() => setDeleteId(announcement.id)}>
                                        <Trash2 className="h-4 w-4" />
                                    </Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                )) : (
                    <Card>
                        <CardContent className="py-12 text-center">
                            <Megaphone className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                            <h3 className="text-lg font-medium text-gray-900 mb-1">No announcements yet</h3>
                            <p className="text-gray-500 mb-4">Create your first announcement to communicate with students.</p>
                            <Button onClick={() => setIsCreateOpen(true)} className="bg-green-600 hover:bg-green-700">
                                <Plus className="h-4 w-4 mr-2" />
                                Create Announcement
                            </Button>
                        </CardContent>
                    </Card>
                )}
            </div>

            {/* Edit Dialog */}
            <Dialog open={isEditOpen} onOpenChange={(open) => { setIsEditOpen(open); if (!open) { setEditingAnnouncement(null); resetForm(); } }}>
                <DialogContent className="sm:max-w-[500px]">
                    <DialogHeader>
                        <DialogTitle>Edit Announcement</DialogTitle>
                    </DialogHeader>
                    <AnnouncementForm onSubmit={handleUpdate} submitLabel="Update Announcement" />
                </DialogContent>
            </Dialog>

            {/* Delete Confirmation */}
            <AlertDialog open={!!deleteId} onOpenChange={() => setDeleteId(null)}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Delete Announcement?</AlertDialogTitle>
                        <AlertDialogDescription>
                            This action cannot be undone. This will permanently delete the announcement.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction onClick={handleDelete} className="bg-red-600 hover:bg-red-700">
                            Delete
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </TeacherLayout>
    );
}
