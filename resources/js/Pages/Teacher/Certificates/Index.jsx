import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent } from '../../../components/ui/card';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../../components/ui/table';
import { Trophy, Award, Calendar, Search, Download, BookOpen } from 'lucide-react';

export default function CertificatesIndex({ certificates, stats, courses, filters }) {
    const [search, setSearch] = React.useState(filters.search || '');

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('teacher.certificates'), { ...filters, search }, { preserveState: true });
    };

    const handleFilterChange = (key, value) => {
        router.get(route('teacher.certificates'), {
            ...filters,
            [key]: value || undefined,
        }, { preserveState: true });
    };

    return (
        <TeacherLayout>
            <Head title="Certificates" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Certificates</h1>
                    <p className="mt-1 text-gray-500">Certificates issued to students who completed your courses.</p>
                </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <Card className="bg-gradient-to-br from-amber-50 to-amber-100 border-amber-200">
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-amber-700 flex items-center gap-2">
                            <Trophy className="h-4 w-4" />
                            Total Issued
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-3xl font-bold text-amber-800">{stats.total}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <Calendar className="h-4 w-4" />
                            This Month
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">{stats.thisMonth}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <BookOpen className="h-4 w-4" />
                            Courses with Certificates
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-blue-600">{stats.coursesWithCerts}</div>
                    </CardContent>
                </Card>
            </div>

            {/* Filters */}
            <Card className="mb-6">
                <CardContent className="pt-6">
                    <div className="flex flex-wrap gap-4 items-end">
                        <form onSubmit={handleSearch} className="flex-1 min-w-[200px]">
                            <div className="relative">
                                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                <Input
                                    placeholder="Search by student name or email..."
                                    value={search}
                                    onChange={(e) => setSearch(e.target.value)}
                                    className="pl-10"
                                />
                            </div>
                        </form>
                        <select
                            value={filters.course_id || ''}
                            onChange={(e) => handleFilterChange('course_id', e.target.value)}
                            className="border border-gray-300 rounded-lg px-3 py-2 text-sm"
                        >
                            <option value="">All Courses</option>
                            {courses.map((course) => (
                                <option key={course.id} value={course.id}>{course.title}</option>
                            ))}
                        </select>
                        {(filters.course_id || filters.search) && (
                            <Button
                                variant="ghost"
                                size="sm"
                                onClick={() => { setSearch(''); router.get(route('teacher.certificates')); }}
                            >
                                Clear filters
                            </Button>
                        )}
                    </div>
                </CardContent>
            </Card>

            {/* Certificates Table */}
            <Card>
                <CardContent className="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[300px]">Student</TableHead>
                                <TableHead>Course</TableHead>
                                <TableHead>Certificate #</TableHead>
                                <TableHead>Issued</TableHead>
                                <TableHead>Valid Until</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {certificates.data.length > 0 ? certificates.data.map((cert) => (
                                <TableRow key={cert.id}>
                                    <TableCell>
                                        <div className="flex items-center gap-3">
                                            {cert.student.avatarUrl ? (
                                                <img src={cert.student.avatarUrl} alt={cert.student.name} className="h-10 w-10 rounded-full object-cover shrink-0" />
                                            ) : (
                                                <div className="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-bold shrink-0">
                                                    {cert.student.name.charAt(0).toUpperCase()}
                                                </div>
                                            )}
                                            <div>
                                                <div className="font-medium text-gray-900">{cert.student.name}</div>
                                                <div className="text-sm text-gray-500">{cert.student.email}</div>
                                            </div>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <span className="text-sm text-gray-600">{cert.course.title}</span>
                                    </TableCell>
                                    <TableCell>
                                        <code className="text-sm bg-gray-100 px-2 py-1 rounded">{cert.certificateNumber}</code>
                                    </TableCell>
                                    <TableCell>
                                        <div className="flex items-center gap-1 text-sm text-gray-600">
                                            <Award className="h-4 w-4 text-amber-500" />
                                            {cert.issuedAt}
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        {cert.validUntil ? (
                                            <span className="text-sm text-gray-600">{cert.validUntil}</span>
                                        ) : (
                                            <Badge variant="secondary" className="bg-green-50 text-green-700">Lifetime</Badge>
                                        )}
                                    </TableCell>
                                    <TableCell className="text-right">
                                        {cert.filePath && (
                                            <Button variant="ghost" size="sm" asChild>
                                                <a href={`/storage/${cert.filePath}`} target="_blank" rel="noopener noreferrer">
                                                    <Download className="h-4 w-4" />
                                                </a>
                                            </Button>
                                        )}
                                    </TableCell>
                                </TableRow>
                            )) : (
                                <TableRow>
                                    <TableCell colSpan={6} className="h-24 text-center">
                                        <div className="flex flex-col items-center gap-2">
                                            <Trophy className="h-8 w-8 text-gray-300" />
                                            <p className="text-gray-500">No certificates issued yet.</p>
                                            <p className="text-sm text-gray-400">Students earn certificates upon course completion.</p>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>

            {/* Pagination */}
            {certificates.last_page > 1 && (
                <div className="mt-6 flex justify-center gap-2">
                    {certificates.links.map((link, index) => (
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
