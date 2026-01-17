import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Badge } from '../../../components/ui/badge';
import {
    Table, TableBody, TableCell, TableHead, TableHeader, TableRow,
} from '../../../components/ui/table';
import {
    AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent,
    AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle,
} from '../../../components/ui/alert-dialog';
import {
    GraduationCap, Search, BookOpen, CheckCircle, Clock, PlayCircle,
    Trash2, ChevronLeft, ChevronRight
} from 'lucide-react';

export default function Index({ enrollments, stats, filters }) {
    const [search, setSearch] = useState(filters.search || '');
    const [progressFilter, setProgressFilter] = useState(filters.progress || '');
    const [deleteEnrollment, setDeleteEnrollment] = useState(null);

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('admin.enrollments.index'), { search, progress: progressFilter }, { preserveState: true });
    };

    const handleProgressFilter = (progress) => {
        setProgressFilter(progress);
        router.get(route('admin.enrollments.index'), { search, progress }, { preserveState: true });
    };

    const handleDelete = () => {
        if (deleteEnrollment) {
            router.delete(route('admin.enrollments.destroy', deleteEnrollment.id), {
                onSuccess: () => setDeleteEnrollment(null),
            });
        }
    };

    const getProgressBadge = (progress) => {
        if (progress === 100) return <Badge className="bg-green-100 text-green-700">Completed</Badge>;
        if (progress > 0) return <Badge className="bg-blue-100 text-blue-700">In Progress</Badge>;
        return <Badge className="bg-gray-100 text-gray-700">Not Started</Badge>;
    };

    const statCards = [
        { title: 'Total Enrollments', value: stats.total, icon: GraduationCap, color: 'text-blue-600', bgColor: 'bg-blue-50' },
        { title: 'Completed', value: stats.completed, icon: CheckCircle, color: 'text-green-600', bgColor: 'bg-green-50' },
        { title: 'In Progress', value: stats.in_progress, icon: PlayCircle, color: 'text-blue-600', bgColor: 'bg-blue-50' },
        { title: 'Not Started', value: stats.not_started, icon: Clock, color: 'text-gray-600', bgColor: 'bg-gray-50' },
    ];

    return (
        <AdminLayout>
            <Head title="Enrollments" />

            <div className="space-y-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Enrollments</h1>
                    <p className="mt-1 text-gray-500">Manage all course enrollments</p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {statCards.map((stat) => (
                        <Card key={stat.title} className="border-0 shadow-sm bg-white">
                            <CardContent className="p-4">
                                <div className="flex items-center gap-4">
                                    <div className={`p-2 rounded-lg ${stat.bgColor}`}>
                                        <stat.icon className={`h-5 w-5 ${stat.color}`} />
                                    </div>
                                    <div>
                                        <p className="text-2xl font-bold text-gray-900">{stat.value}</p>
                                        <p className="text-sm text-gray-500">{stat.title}</p>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-4">
                        <div className="flex flex-col md:flex-row gap-4">
                            <form onSubmit={handleSearch} className="flex-1 flex gap-2">
                                <div className="relative flex-1">
                                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                    <Input
                                        type="text"
                                        placeholder="Search by user or course..."
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        className="pl-10"
                                    />
                                </div>
                                <Button type="submit" variant="outline" className="text-gray-700 border-gray-300">Search</Button>
                            </form>
                            <div className="flex gap-2">
                                {[
                                    { value: '', label: 'All' },
                                    { value: 'completed', label: 'Completed' },
                                    { value: 'in_progress', label: 'In Progress' },
                                    { value: 'not_started', label: 'Not Started' },
                                ].map((option) => (
                                    <Button
                                        key={option.value}
                                        variant={progressFilter === option.value ? 'default' : 'outline'}
                                        onClick={() => handleProgressFilter(option.value)}
                                        size="sm"
                                        className={progressFilter === option.value ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'text-gray-700 border-gray-300'}
                                    >
                                        {option.label}
                                    </Button>
                                ))}
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow className="bg-gray-50">
                                    <TableHead className="text-gray-700 font-semibold">Student</TableHead>
                                    <TableHead className="text-gray-700 font-semibold">Course</TableHead>
                                    <TableHead className="text-gray-700 font-semibold">Progress</TableHead>
                                    <TableHead className="text-gray-700 font-semibold">Status</TableHead>
                                    <TableHead className="text-gray-700 font-semibold">Enrolled</TableHead>
                                    <TableHead className="text-right text-gray-700 font-semibold">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {enrollments.data.length > 0 ? (
                                    enrollments.data.map((enrollment) => (
                                        <TableRow key={enrollment.id}>
                                            <TableCell>
                                                <div className="flex items-center gap-2">
                                                    {enrollment.user.avatar ? (
                                                        <img src={enrollment.user.avatar} className="h-8 w-8 rounded-full" />
                                                    ) : (
                                                        <div className="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-medium">
                                                            {enrollment.user.name.charAt(0)}
                                                        </div>
                                                    )}
                                                    <div>
                                                        <p className="font-medium text-sm text-gray-900">{enrollment.user.name}</p>
                                                        <p className="text-xs text-gray-500">{enrollment.user.email}</p>
                                                    </div>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2">
                                                    {enrollment.course.thumbnail ? (
                                                        <img src={enrollment.course.thumbnail} className="h-10 w-14 rounded object-cover" />
                                                    ) : (
                                                        <div className="h-10 w-14 rounded bg-gray-100 flex items-center justify-center">
                                                            <BookOpen className="h-5 w-5 text-gray-400" />
                                                        </div>
                                                    )}
                                                    <span className="font-medium text-sm text-gray-900 line-clamp-1">{enrollment.course.title}</span>
                                                </div>
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2">
                                                    <div className="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                        <div
                                                            className="h-full bg-green-500 rounded-full"
                                                            style={{ width: `${enrollment.progress_percentage}%` }}
                                                        />
                                                    </div>
                                                    <span className="text-sm font-medium text-gray-900">{enrollment.progress_percentage}%</span>
                                                </div>
                                            </TableCell>
                                            <TableCell>{getProgressBadge(enrollment.progress_percentage)}</TableCell>
                                            <TableCell className="text-gray-500">{enrollment.enrolled_at}</TableCell>
                                            <TableCell className="text-right">
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    className="text-red-600 hover:text-red-700 hover:bg-red-50"
                                                    onClick={() => setDeleteEnrollment(enrollment)}
                                                >
                                                    <Trash2 className="h-4 w-4" />
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                ) : (
                                    <TableRow>
                                        <TableCell colSpan={6} className="text-center py-12">
                                            <div className="flex flex-col items-center">
                                                <GraduationCap className="h-12 w-12 text-gray-300 mb-4" />
                                                <p className="text-gray-500 text-lg font-medium">No enrollments found</p>
                                                <p className="text-gray-400 text-sm mt-1">Students will appear here when they enroll in courses</p>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                )}
                            </TableBody>
                        </Table>

                        {enrollments.last_page > 1 && (
                            <div className="flex items-center justify-between px-4 py-3 border-t">
                                <p className="text-sm text-gray-500">
                                    Showing {enrollments.from} to {enrollments.to} of {enrollments.total}
                                </p>
                                <div className="flex gap-2">
                                    {enrollments.prev_page_url && (
                                        <Link href={enrollments.prev_page_url}>
                                            <Button variant="outline" size="sm"><ChevronLeft className="h-4 w-4" /></Button>
                                        </Link>
                                    )}
                                    {enrollments.next_page_url && (
                                        <Link href={enrollments.next_page_url}>
                                            <Button variant="outline" size="sm"><ChevronRight className="h-4 w-4" /></Button>
                                        </Link>
                                    )}
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>

            <AlertDialog open={!!deleteEnrollment} onOpenChange={() => setDeleteEnrollment(null)}>
                <AlertDialogContent className="bg-white">
                    <AlertDialogHeader>
                        <AlertDialogTitle className="text-gray-900">Remove Enrollment</AlertDialogTitle>
                        <AlertDialogDescription className="text-gray-600">
                            Are you sure you want to remove this enrollment? The student will lose access to the course.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel className="text-gray-700 border-gray-300">Cancel</AlertDialogCancel>
                        <AlertDialogAction onClick={handleDelete} className="bg-red-600 hover:bg-red-700 text-white">Remove</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </AdminLayout>
    );
}
