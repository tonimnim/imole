import React from 'react';
import { Head, Link } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from '../../../components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../../components/ui/table';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { ClipboardCheck, Users, Clock, FileCheck, ExternalLink } from 'lucide-react';

export default function AssignmentsIndex({ assignments, pendingSubmissions }) {
    return (
        <TeacherLayout>
            <Head title="Assignments" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Assignments</h1>
                    <p className="mt-1 text-gray-500">Manage assignments and grade student submissions.</p>
                </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Assignments</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{assignments.length}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Published</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">
                            {assignments.filter(a => a.isPublished).length}
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Submissions</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-blue-600">
                            {assignments.reduce((acc, a) => acc + a.submissionsCount, 0)}
                        </div>
                    </CardContent>
                </Card>
                <Card className="border-amber-200 bg-amber-50">
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-amber-700">Pending Grading</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-amber-600">{pendingSubmissions.length}</div>
                    </CardContent>
                </Card>
            </div>

            {/* Pending Submissions */}
            {pendingSubmissions.length > 0 && (
                <Card className="mb-8 border-amber-200">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            <Clock className="h-5 w-5 text-amber-600" />
                            Pending Submissions to Grade
                        </CardTitle>
                        <CardDescription>Students waiting for feedback</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-3">
                            {pendingSubmissions.map((submission) => (
                                <div key={submission.id} className="flex items-center justify-between p-3 bg-white rounded-lg border">
                                    <div className="flex items-center gap-3">
                                        <div className="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center font-medium text-gray-600">
                                            {submission.student.charAt(0)}
                                        </div>
                                        <div>
                                            <div className="font-medium text-gray-900">{submission.student}</div>
                                            <div className="text-sm text-gray-500">{submission.assignment}</div>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <span className="text-xs text-gray-500">{submission.submittedAt}</span>
                                        <Button size="sm" className="bg-green-600 hover:bg-green-700">
                                            <FileCheck className="h-4 w-4 mr-1" />
                                            Grade
                                        </Button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>
            )}

            {/* Assignments Table */}
            <Card>
                <CardHeader>
                    <CardTitle>All Assignments</CardTitle>
                </CardHeader>
                <CardContent className="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[300px]">Assignment</TableHead>
                                <TableHead>Course</TableHead>
                                <TableHead>Lesson</TableHead>
                                <TableHead className="text-center">Max Score</TableHead>
                                <TableHead className="text-center">Submissions</TableHead>
                                <TableHead>Due Date</TableHead>
                                <TableHead>Status</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {assignments.length > 0 ? assignments.map((assignment) => (
                                <TableRow key={assignment.id}>
                                    <TableCell>
                                        <div className="flex items-center gap-3">
                                            <div className="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                                <ClipboardCheck className="h-5 w-5 text-purple-600" />
                                            </div>
                                            <div className="font-medium text-gray-900">{assignment.title}</div>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <span className="text-sm text-gray-600">{assignment.course}</span>
                                    </TableCell>
                                    <TableCell>
                                        <span className="text-sm text-gray-600">{assignment.lesson}</span>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <Badge variant="secondary">{assignment.maxScore} pts</Badge>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <div className="flex items-center justify-center gap-1 text-gray-600">
                                            <Users className="h-4 w-4" />
                                            <span>{assignment.submissionsCount}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <span className="text-sm text-gray-600">
                                            {assignment.dueDate || 'No deadline'}
                                        </span>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant={assignment.isPublished ? 'success' : 'secondary'}>
                                            {assignment.isPublished ? 'Published' : 'Draft'}
                                        </Badge>
                                    </TableCell>
                                </TableRow>
                            )) : (
                                <TableRow>
                                    <TableCell colSpan={7} className="h-24 text-center text-gray-500">
                                        No assignments found. Create assignments in the curriculum builder.
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
