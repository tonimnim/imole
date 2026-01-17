import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Badge } from '../../../components/ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '../../../components/ui/table';
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
    BookOpen,
    Search,
    Trash2,
    Star,
    Eye,
    EyeOff,
    Award,
    ChevronLeft,
    ChevronRight,
    Users,
    Layers,
    PlayCircle
} from 'lucide-react';

export default function Index({ courses, categories, stats, filters }) {
    const [search, setSearch] = useState(filters.search || '');
    const [statusFilter, setStatusFilter] = useState(filters.status || '');
    const [categoryFilter, setCategoryFilter] = useState(filters.category || '');
    const [deleteCourse, setDeleteCourse] = useState(null);

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('admin.courses.index'), {
            search,
            status: statusFilter,
            category: categoryFilter
        }, { preserveState: true });
    };

    const handleStatusFilter = (status) => {
        setStatusFilter(status);
        router.get(route('admin.courses.index'), {
            search,
            status,
            category: categoryFilter
        }, { preserveState: true });
    };

    const handleCategoryFilter = (e) => {
        setCategoryFilter(e.target.value);
        router.get(route('admin.courses.index'), {
            search,
            status: statusFilter,
            category: e.target.value
        }, { preserveState: true });
    };

    const handleTogglePublish = (course) => {
        router.post(route('admin.courses.toggle-publish', course.id), {}, { preserveState: true });
    };

    const handleToggleFeatured = (course) => {
        router.post(route('admin.courses.toggle-featured', course.id), {}, { preserveState: true });
    };

    const handleDelete = () => {
        if (deleteCourse) {
            router.delete(route('admin.courses.destroy', deleteCourse.id), {
                onSuccess: () => setDeleteCourse(null),
            });
        }
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-KE', {
            style: 'currency',
            currency: 'KES',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    const statCards = [
        { title: 'Total Courses', value: stats.total, icon: BookOpen, color: 'text-blue-600', bgColor: 'bg-blue-50' },
        { title: 'Published', value: stats.published, icon: Eye, color: 'text-green-600', bgColor: 'bg-green-50' },
        { title: 'Draft', value: stats.draft, icon: EyeOff, color: 'text-gray-600', bgColor: 'bg-gray-50' },
        { title: 'Featured', value: stats.featured, icon: Award, color: 'text-amber-600', bgColor: 'bg-amber-50' },
    ];

    return (
        <AdminLayout>
            <Head title="Courses Management" />

            <div className="space-y-6">
                {/* Header */}
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Courses</h1>
                    <p className="mt-1 text-gray-500">Manage all platform courses</p>
                </div>

                {/* Stats */}
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

                {/* Filters */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-4">
                        <div className="flex flex-col md:flex-row gap-4">
                            <form onSubmit={handleSearch} className="flex-1 flex gap-2">
                                <div className="relative flex-1">
                                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                    <Input
                                        type="text"
                                        placeholder="Search courses..."
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        className="pl-10"
                                    />
                                </div>
                                <Button type="submit" variant="outline">Search</Button>
                            </form>
                            <select
                                value={categoryFilter}
                                onChange={handleCategoryFilter}
                                className="h-10 px-3 rounded-md border border-gray-200 bg-white text-sm"
                            >
                                <option value="">All Categories</option>
                                {Object.entries(categories).map(([id, name]) => (
                                    <option key={id} value={id}>{name}</option>
                                ))}
                            </select>
                            <div className="flex gap-2">
                                <Button
                                    variant={statusFilter === '' ? 'default' : 'outline'}
                                    onClick={() => handleStatusFilter('')}
                                    size="sm"
                                >
                                    All
                                </Button>
                                <Button
                                    variant={statusFilter === 'published' ? 'default' : 'outline'}
                                    onClick={() => handleStatusFilter('published')}
                                    size="sm"
                                >
                                    Published
                                </Button>
                                <Button
                                    variant={statusFilter === 'draft' ? 'default' : 'outline'}
                                    onClick={() => handleStatusFilter('draft')}
                                    size="sm"
                                >
                                    Draft
                                </Button>
                                <Button
                                    variant={statusFilter === 'featured' ? 'default' : 'outline'}
                                    onClick={() => handleStatusFilter('featured')}
                                    size="sm"
                                >
                                    Featured
                                </Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Courses Table */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Course</TableHead>
                                    <TableHead>Instructor</TableHead>
                                    <TableHead>Category</TableHead>
                                    <TableHead>Price</TableHead>
                                    <TableHead>Stats</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead className="text-right">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {courses.data.map((course) => (
                                    <TableRow key={course.id}>
                                        <TableCell>
                                            <div className="flex items-center gap-3">
                                                {course.thumbnail ? (
                                                    <img src={course.thumbnail} alt={course.title} className="h-12 w-16 rounded object-cover" />
                                                ) : (
                                                    <div className="h-12 w-16 rounded bg-gray-100 flex items-center justify-center">
                                                        <BookOpen className="h-6 w-6 text-gray-400" />
                                                    </div>
                                                )}
                                                <div>
                                                    <p className="font-medium text-gray-900 line-clamp-1">{course.title}</p>
                                                    <div className="flex items-center gap-1 text-amber-500">
                                                        <Star className="h-3 w-3 fill-current" />
                                                        <span className="text-xs">{course.average_rating}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <div className="flex items-center gap-2">
                                                {course.instructor.avatar ? (
                                                    <img src={course.instructor.avatar} alt={course.instructor.name} className="h-8 w-8 rounded-full object-cover" />
                                                ) : (
                                                    <div className="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-medium text-xs">
                                                        {course.instructor.name.charAt(0)}
                                                    </div>
                                                )}
                                                <span className="text-sm text-gray-700">{course.instructor.name}</span>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <Badge variant="outline">{course.category || 'Uncategorized'}</Badge>
                                        </TableCell>
                                        <TableCell className="font-medium">
                                            {course.price > 0 ? formatCurrency(course.price) : 'Free'}
                                        </TableCell>
                                        <TableCell>
                                            <div className="flex items-center gap-3 text-xs text-gray-500">
                                                <span className="flex items-center gap-1">
                                                    <Users className="h-3 w-3" /> {course.enrollments_count}
                                                </span>
                                                <span className="flex items-center gap-1">
                                                    <Layers className="h-3 w-3" /> {course.modules_count}
                                                </span>
                                                <span className="flex items-center gap-1">
                                                    <PlayCircle className="h-3 w-3" /> {course.lessons_count}
                                                </span>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <div className="flex flex-col gap-1">
                                                <Badge variant={course.is_published ? 'default' : 'secondary'}>
                                                    {course.is_published ? 'Published' : 'Draft'}
                                                </Badge>
                                                {course.is_featured && (
                                                    <Badge className="bg-amber-100 text-amber-700">Featured</Badge>
                                                )}
                                            </div>
                                        </TableCell>
                                        <TableCell className="text-right">
                                            <div className="flex items-center justify-end gap-1">
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    onClick={() => handleTogglePublish(course)}
                                                    title={course.is_published ? 'Unpublish' : 'Publish'}
                                                >
                                                    {course.is_published ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                                </Button>
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    onClick={() => handleToggleFeatured(course)}
                                                    className={course.is_featured ? 'text-amber-600' : ''}
                                                    title={course.is_featured ? 'Unfeature' : 'Feature'}
                                                >
                                                    <Award className="h-4 w-4" />
                                                </Button>
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    className="text-red-600 hover:text-red-700 hover:bg-red-50"
                                                    onClick={() => setDeleteCourse(course)}
                                                >
                                                    <Trash2 className="h-4 w-4" />
                                                </Button>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>

                        {/* Pagination */}
                        {courses.last_page > 1 && (
                            <div className="flex items-center justify-between px-4 py-3 border-t">
                                <p className="text-sm text-gray-500">
                                    Showing {courses.from} to {courses.to} of {courses.total} courses
                                </p>
                                <div className="flex gap-2">
                                    {courses.prev_page_url && (
                                        <Link href={courses.prev_page_url}>
                                            <Button variant="outline" size="sm">
                                                <ChevronLeft className="h-4 w-4 mr-1" /> Previous
                                            </Button>
                                        </Link>
                                    )}
                                    {courses.next_page_url && (
                                        <Link href={courses.next_page_url}>
                                            <Button variant="outline" size="sm">
                                                Next <ChevronRight className="h-4 w-4 ml-1" />
                                            </Button>
                                        </Link>
                                    )}
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>

            {/* Delete Confirmation Dialog */}
            <AlertDialog open={!!deleteCourse} onOpenChange={() => setDeleteCourse(null)}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Delete Course</AlertDialogTitle>
                        <AlertDialogDescription>
                            Are you sure you want to delete "{deleteCourse?.title}"? This will also delete all modules, lessons, and enrollments. This action cannot be undone.
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
        </AdminLayout>
    );
}
