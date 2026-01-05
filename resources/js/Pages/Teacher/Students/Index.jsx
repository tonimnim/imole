import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent } from '../../../components/ui/card';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Users, UserCheck, GraduationCap, TrendingUp, Search, Mail, BookOpen } from 'lucide-react';

export default function StudentsIndex({ students, stats, filters }) {
    const [search, setSearch] = React.useState(filters.search || '');

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('teacher.students'), { search }, { preserveState: true });
    };

    return (
        <TeacherLayout>
            <Head title="Students" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Students</h1>
                    <p className="mt-1 text-gray-500">Students enrolled across all your courses.</p>
                </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <Users className="h-4 w-4" />
                            Total Students
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{stats.total}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <UserCheck className="h-4 w-4" />
                            Active (7 days)
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">{stats.active}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <GraduationCap className="h-4 w-4" />
                            Completed
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-blue-600">{stats.completed}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <TrendingUp className="h-4 w-4" />
                            Avg Progress
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-purple-600">{stats.avgProgress}%</div>
                    </CardContent>
                </Card>
            </div>

            {/* Search */}
            <Card className="mb-6">
                <CardContent className="pt-6">
                    <form onSubmit={handleSearch} className="flex gap-4">
                        <div className="relative flex-1">
                            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                            <Input
                                placeholder="Search by name or email..."
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                                className="pl-10"
                            />
                        </div>
                        <Button type="submit">Search</Button>
                    </form>
                </CardContent>
            </Card>

            {/* Students List */}
            <div className="grid gap-4">
                {students.data.length > 0 ? students.data.map((student) => (
                    <Card key={student.id} className="hover:shadow-md transition-shadow">
                        <CardContent className="p-6">
                            <div className="flex items-start gap-4">
                                {/* Avatar */}
                                {student.avatarUrl ? (
                                    <img src={student.avatarUrl} alt={student.name} className="h-14 w-14 rounded-full object-cover shrink-0" />
                                ) : (
                                    <div className="h-14 w-14 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xl font-bold shrink-0">
                                        {student.name.charAt(0).toUpperCase()}
                                    </div>
                                )}

                                {/* Info */}
                                <div className="flex-1 min-w-0">
                                    <div className="flex items-center gap-3 mb-1">
                                        <h3 className="font-semibold text-gray-900 text-lg">{student.name}</h3>
                                        <Badge variant="secondary" className="bg-blue-50 text-blue-700">
                                            {student.coursesCount} {student.coursesCount === 1 ? 'course' : 'courses'}
                                        </Badge>
                                    </div>
                                    <div className="flex items-center gap-2 text-gray-500 text-sm mb-3">
                                        <Mail className="h-4 w-4" />
                                        {student.email}
                                    </div>

                                    {/* Enrolled Courses */}
                                    <div className="flex flex-wrap gap-2">
                                        {student.courses.slice(0, 3).map((course) => (
                                            <div key={course.id} className="flex items-center gap-2 bg-gray-50 rounded-lg px-3 py-2">
                                                <BookOpen className="h-4 w-4 text-gray-400" />
                                                <span className="text-sm font-medium text-gray-700 truncate max-w-[150px]">{course.title}</span>
                                                <div className="flex items-center gap-1">
                                                    <div className="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                                        <div
                                                            className="h-full bg-green-500 rounded-full"
                                                            style={{ width: `${course.progress}%` }}
                                                        />
                                                    </div>
                                                    <span className="text-xs text-gray-500">{course.progress}%</span>
                                                </div>
                                            </div>
                                        ))}
                                        {student.courses.length > 3 && (
                                            <div className="text-sm text-gray-500 self-center">
                                                +{student.courses.length - 3} more
                                            </div>
                                        )}
                                    </div>
                                </div>

                                {/* Stats */}
                                <div className="text-right shrink-0">
                                    <div className="text-2xl font-bold text-green-600">{student.avgProgress}%</div>
                                    <div className="text-xs text-gray-500">Avg Progress</div>
                                    <div className="text-xs text-gray-400 mt-2">Joined {student.joinedAt}</div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                )) : (
                    <Card>
                        <CardContent className="py-12 text-center">
                            <Users className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                            <h3 className="text-lg font-medium text-gray-900 mb-1">No students found</h3>
                            <p className="text-gray-500">Students who enroll in your courses will appear here.</p>
                        </CardContent>
                    </Card>
                )}
            </div>

            {/* Pagination */}
            {students.last_page > 1 && (
                <div className="mt-6 flex justify-center gap-2">
                    {students.links.map((link, index) => (
                        <Link
                            key={index}
                            href={link.url || '#'}
                            className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                                link.active
                                    ? 'bg-green-600 text-white'
                                    : link.url
                                    ? 'bg-white text-gray-700 hover:bg-gray-50 border'
                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                            }`}
                            dangerouslySetInnerHTML={{ __html: link.label }}
                        />
                    ))}
                </div>
            )}
        </TeacherLayout>
    );
}
