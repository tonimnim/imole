import React from 'react';
import { Head, Link } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent } from '../../../components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../../components/ui/table';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { Layers, BookOpen, ExternalLink } from 'lucide-react';

export default function ModulesIndex({ modules }) {
    return (
        <TeacherLayout>
            <Head title="Modules" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Modules</h1>
                    <p className="mt-1 text-gray-500">Overview of all course sections across your courses.</p>
                </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Modules</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{modules.length}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Published</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">
                            {modules.filter(m => m.isPublished).length}
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Lessons</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-blue-600">
                            {modules.reduce((acc, m) => acc + m.lessonsCount, 0)}
                        </div>
                    </CardContent>
                </Card>
            </div>

            {/* Table */}
            <Card>
                <CardContent className="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[300px]">Module</TableHead>
                                <TableHead>Course</TableHead>
                                <TableHead className="text-center">Lessons</TableHead>
                                <TableHead className="text-center">Order</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {modules.length > 0 ? modules.map((module) => (
                                <TableRow key={module.id}>
                                    <TableCell>
                                        <div className="flex items-center gap-3">
                                            <div className="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                                <Layers className="h-5 w-5 text-green-600" />
                                            </div>
                                            <div>
                                                <div className="font-medium text-gray-900">{module.title}</div>
                                                <div className="text-xs text-gray-500 truncate max-w-[200px]">
                                                    {module.description || 'No description'}
                                                </div>
                                            </div>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <span className="text-sm text-gray-600">{module.course}</span>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <div className="flex items-center justify-center gap-1 text-gray-600">
                                            <BookOpen className="h-4 w-4" />
                                            <span>{module.lessonsCount}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <Badge variant="secondary">{module.order}</Badge>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant={module.isPublished ? 'success' : 'secondary'}>
                                            {module.isPublished ? 'Published' : 'Draft'}
                                        </Badge>
                                    </TableCell>
                                    <TableCell className="text-right">
                                        <Link href={route('teacher.curriculum', module.courseId)}>
                                            <Button variant="ghost" size="sm">
                                                <ExternalLink className="h-4 w-4 mr-1" />
                                                Edit in Curriculum
                                            </Button>
                                        </Link>
                                    </TableCell>
                                </TableRow>
                            )) : (
                                <TableRow>
                                    <TableCell colSpan={6} className="h-24 text-center text-gray-500">
                                        No modules found. Create modules in the curriculum builder.
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
