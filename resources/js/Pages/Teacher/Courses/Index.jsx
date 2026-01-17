import React from 'react';
import { Head, Link } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent } from '../../../components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../../components/ui/table';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger, DropdownMenuSeparator } from '../../../components/ui/dropdown-menu';
import { MoreHorizontal, Plus, Pencil, Trash2, Eye, BookOpen, Users } from 'lucide-react';

export default function CoursesIndex({ courses, stats }) {
    
    const getStatusVariant = (status) => {
        switch(status) {
            case 'published': return 'success';
            case 'pending': return 'warning';
            default: return 'secondary';
        }
    };

    return (
        <TeacherLayout>
            <Head title="My Courses" />

            {/* Header */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">My Courses</h1>
                    <p className="mt-1 text-gray-500">Manage your course content and curriculum.</p>
                </div>
                <Link href={route('teacher.courses.create')}>
                    <Button className="bg-green-600 hover:bg-green-700">
                        <Plus className="mr-2 h-4 w-4" />
                        Create New Course
                    </Button>
                </Link>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <Card className="bg-white">
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Courses</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{stats.total}</div>
                    </CardContent>
                </Card>
                <Card className="bg-white">
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Published</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">{stats.published}</div>
                    </CardContent>
                </Card>
                <Card className="bg-white">
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Drafts</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-gray-600">{stats.draft}</div>
                    </CardContent>
                </Card>
                <Card className="bg-white">
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Students</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-blue-600">{stats.totalStudents}</div>
                    </CardContent>
                </Card>
            </div>

            {/* Courses List */}
            <Card>
                <CardContent className="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[400px]">Course</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Price</TableHead>
                                <TableHead className="text-center">Students</TableHead>
                                <TableHead className="text-center">Lessons</TableHead>
                                <TableHead className="text-center">Rating</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {courses.length > 0 ? courses.map((course) => (
                                <TableRow key={course.id}>
                                    <TableCell>
                                        <div className="flex items-center gap-3">
                                            <div className="h-12 w-12 rounded bg-gray-100 flex-shrink-0 overflow-hidden border border-gray-200">
                                                {course.thumbnail ? (
                                                    <img src={course.thumbnail} alt="" className="h-full w-full object-cover" />
                                                ) : (
                                                    <div className="h-full w-full flex items-center justify-center text-gray-400">
                                                        <BookOpen size={20} />
                                                    </div>
                                                )}
                                            </div>
                                            <div>
                                                <div className="font-medium text-gray-900">{course.title}</div>
                                                <div className="text-xs text-gray-500">{course.category}</div>
                                            </div>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant={getStatusVariant(course.status)}>
                                            {course.status}
                                        </Badge>
                                    </TableCell>
                                    <TableCell>
                                        {parseFloat(course.price) > 0 ? (
                                            <span className="font-medium">Ksh{parseFloat(course.price).toLocaleString()}</span>
                                        ) : (
                                            <Badge variant="secondary">Free</Badge>
                                        )}
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <div className="flex items-center justify-center gap-1 text-gray-600">
                                            <Users size={14} />
                                            <span>{course.studentsCount}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <span className="text-sm text-gray-600">{course.lessonsCount}</span>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <div className="flex items-center justify-center gap-1 text-yellow-500 font-medium">
                                            <span>★</span>
                                            <span>{course.rating}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell className="text-right">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button variant="ghost" className="h-8 w-8 p-0">
                                                    <span className="sr-only">Open menu</span>
                                                    <MoreHorizontal className="h-4 w-4" />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="end">
                                                <DropdownMenuItem onClick={() => window.location.href = route('teacher.courses.edit', course.id)}>
                                                    <Pencil className="mr-2 h-4 w-4" />
                                                    Edit Course
                                                </DropdownMenuItem>
                                                <DropdownMenuItem onClick={() => window.location.href = route('teacher.curriculum', course.id)}>
                                                    <BookOpen className="mr-2 h-4 w-4" />
                                                    Manage Curriculum
                                                </DropdownMenuItem>
                                                <DropdownMenuItem>
                                                    <Eye className="mr-2 h-4 w-4" />
                                                    Preview
                                                </DropdownMenuItem>
                                                <DropdownMenuSeparator />
                                                <DropdownMenuItem className="text-red-600">
                                                    <Trash2 className="mr-2 h-4 w-4" />
                                                    Delete
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                </TableRow>
                            )) : (
                                <TableRow>
                                    <TableCell colSpan={7} className="h-24 text-center text-muted-foreground">
                                        No courses found. Get started by creating one!
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
