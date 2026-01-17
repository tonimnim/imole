import React from 'react';
import { Head, Link } from '@inertiajs/react';
import TeacherLayout from '../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from '../../components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../components/ui/table';
import { BookOpen, Users, Trophy, DollarSign, Star, TrendingUp } from 'lucide-react';
import { Button } from '../../components/ui/button';

export default function Dashboard({ stats, recentEnrollments, topCourses }) {
    return (
        <TeacherLayout>
            <Head title="Dashboard" />
            
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p className="mt-1 text-gray-500">Overview of your teaching performance.</p>
                </div>
                <Link href={route('teacher.courses.create')}>
                    <Button className="bg-green-600 hover:bg-green-700">
                        Create New Course
                    </Button>
                </Link>
            </div>

            {/* Stats Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">Total Revenue</CardTitle>
                        <DollarSign className="h-4 w-4 text-green-600" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">Ksh{stats.totalRevenue.toLocaleString()}</div>
                        <p className="text-xs text-muted-foreground">Lifetime earnings</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">Total Students</CardTitle>
                        <Users className="h-4 w-4 text-blue-600" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{stats.totalStudents}</div>
                        <p className="text-xs text-muted-foreground">Unique learners</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">Active Courses</CardTitle>
                        <BookOpen className="h-4 w-4 text-orange-600" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{stats.totalCourses}</div>
                        <p className="text-xs text-muted-foreground">Published content</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle className="text-sm font-medium">Avg. Rating</CardTitle>
                        <Star className="h-4 w-4 text-yellow-500" />
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{stats.averageRating}</div>
                        <p className="text-xs text-muted-foreground">From student reviews</p>
                    </CardContent>
                </Card>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {/* Top Performing Courses */}
                <Card className="col-span-1 lg:col-span-2">
                    <CardHeader>
                        <CardTitle>Top Performing Courses</CardTitle>
                        <CardDescription>Your most popular content based on enrollments.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Course Title</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Students</TableHead>
                                    <TableHead className="text-right">Price</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {topCourses.length > 0 ? topCourses.map((course) => (
                                    <TableRow key={course.id}>
                                        <TableCell className="font-medium">{course.title}</TableCell>
                                        <TableCell>
                                            <span className={`px-2 py-1 rounded-full text-xs font-semibold ${course.status === 'Published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}`}>
                                                {course.status}
                                            </span>
                                        </TableCell>
                                        <TableCell>{course.students}</TableCell>
                                        <TableCell className="text-right">Ksh{parseFloat(course.price).toLocaleString()}</TableCell>
                                    </TableRow>
                                )) : (
                                    <TableRow>
                                        <TableCell colSpan={4} className="text-center text-muted-foreground py-8">
                                            No courses found.
                                        </TableCell>
                                    </TableRow>
                                )}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>

                {/* Recent Enrollments */}
                <Card className="col-span-1">
                    <CardHeader>
                        <CardTitle>Recent Enrollments</CardTitle>
                        <CardDescription>Latest students joining your courses.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-8">
                            {recentEnrollments.length > 0 ? recentEnrollments.map((enrollment) => (
                                <div key={enrollment.id} className="flex items-center">
                                    <div className="h-9 w-9 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-500">
                                        {enrollment.student.name.charAt(0)}
                                    </div>
                                    <div className="ml-4 space-y-1">
                                        <p className="text-sm font-medium leading-none">{enrollment.student.name}</p>
                                        <p className="text-xs text-muted-foreground line-clamp-1">{enrollment.course}</p>
                                    </div>
                                    <div className="ml-auto font-medium text-xs text-green-600">
                                        +Ksh{parseFloat(enrollment.amount).toLocaleString()}
                                    </div>
                                </div>
                            )) : (
                                <div className="text-center text-sm text-muted-foreground py-4">
                                    No recent enrollments.
                                </div>
                            )}
                        </div>
                    </CardContent>
                </Card>
            </div>
        </TeacherLayout>
    );
}