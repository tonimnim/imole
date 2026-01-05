import React from 'react';
import { Head, Link } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent } from '../../../components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../../components/ui/table';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { Play, FileText, HelpCircle, ClipboardCheck, ExternalLink, Eye } from 'lucide-react';

const LESSON_TYPES = {
    video: { label: 'Video', icon: Play, color: 'bg-blue-100 text-blue-600' },
    text: { label: 'Text', icon: FileText, color: 'bg-green-100 text-green-600' },
    quiz: { label: 'Quiz', icon: HelpCircle, color: 'bg-amber-100 text-amber-600' },
    assignment: { label: 'Assignment', icon: ClipboardCheck, color: 'bg-purple-100 text-purple-600' },
};

export default function LessonsIndex({ lessons }) {
    return (
        <TeacherLayout>
            <Head title="Lessons" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Lessons</h1>
                    <p className="mt-1 text-gray-500">All lessons across your courses.</p>
                </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-8">
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{lessons.length}</div>
                    </CardContent>
                </Card>
                {Object.entries(LESSON_TYPES).map(([type, config]) => (
                    <Card key={type}>
                        <CardHeader className="pb-2">
                            <CardTitle className="text-sm font-medium text-gray-500">{config.label}</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">
                                {lessons.filter(l => l.type === type).length}
                            </div>
                        </CardContent>
                    </Card>
                ))}
            </div>

            {/* Table */}
            <Card>
                <CardContent className="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[300px]">Lesson</TableHead>
                                <TableHead>Course</TableHead>
                                <TableHead>Module</TableHead>
                                <TableHead className="text-center">Type</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {lessons.length > 0 ? lessons.map((lesson) => {
                                const typeConfig = LESSON_TYPES[lesson.type] || LESSON_TYPES.text;
                                const TypeIcon = typeConfig.icon;
                                return (
                                    <TableRow key={lesson.id}>
                                        <TableCell>
                                            <div className="flex items-center gap-3">
                                                <div className={`h-10 w-10 rounded-lg flex items-center justify-center ${typeConfig.color}`}>
                                                    <TypeIcon className="h-5 w-5" />
                                                </div>
                                                <div>
                                                    <div className="font-medium text-gray-900">{lesson.title}</div>
                                                    {lesson.duration > 0 && (
                                                        <div className="text-xs text-gray-500">{lesson.duration} min</div>
                                                    )}
                                                </div>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <span className="text-sm text-gray-600">{lesson.course}</span>
                                        </TableCell>
                                        <TableCell>
                                            <span className="text-sm text-gray-600">{lesson.module}</span>
                                        </TableCell>
                                        <TableCell className="text-center">
                                            <Badge variant="secondary" className={typeConfig.color}>
                                                {typeConfig.label}
                                            </Badge>
                                        </TableCell>
                                        <TableCell>
                                            <div className="flex items-center gap-1">
                                                {lesson.isFree && (
                                                    <Badge variant="secondary" className="bg-green-50 text-green-700">
                                                        Free
                                                    </Badge>
                                                )}
                                                <Badge variant={lesson.isPublished ? 'success' : 'secondary'}>
                                                    {lesson.isPublished ? 'Published' : 'Draft'}
                                                </Badge>
                                            </div>
                                        </TableCell>
                                        <TableCell className="text-right">
                                            <Link href={route('teacher.curriculum', lesson.courseId)}>
                                                <Button variant="ghost" size="sm">
                                                    <ExternalLink className="h-4 w-4 mr-1" />
                                                    Edit
                                                </Button>
                                            </Link>
                                        </TableCell>
                                    </TableRow>
                                );
                            }) : (
                                <TableRow>
                                    <TableCell colSpan={6} className="h-24 text-center text-gray-500">
                                        No lessons found. Create lessons in the curriculum builder.
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </TeacherLayout>
    );
}
