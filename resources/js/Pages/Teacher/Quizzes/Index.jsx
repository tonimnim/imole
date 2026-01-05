import React from 'react';
import { Head, Link } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from '../../../components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../../components/ui/table';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { HelpCircle, Users, Clock, CheckCircle, XCircle, ExternalLink } from 'lucide-react';

export default function QuizzesIndex({ quizzes, recentAttempts }) {
    return (
        <TeacherLayout>
            <Head title="Quizzes" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Quizzes</h1>
                    <p className="mt-1 text-gray-500">Manage quizzes and review student attempts.</p>
                </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-8">
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Quizzes</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{quizzes.length}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Questions</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-blue-600">
                            {quizzes.reduce((acc, q) => acc + q.questionsCount, 0)}
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Attempts</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-purple-600">
                            {quizzes.reduce((acc, q) => acc + q.attemptsCount, 0)}
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Published</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">
                            {quizzes.filter(q => q.isPublished).length}
                        </div>
                    </CardContent>
                </Card>
            </div>

            {/* Recent Attempts */}
            {recentAttempts.length > 0 && (
                <Card className="mb-8">
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            <Clock className="h-5 w-5 text-gray-600" />
                            Recent Quiz Attempts
                        </CardTitle>
                        <CardDescription>Latest student quiz completions</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-3">
                            {recentAttempts.map((attempt) => (
                                <div key={attempt.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div className="flex items-center gap-3">
                                        <div className={`h-10 w-10 rounded-full flex items-center justify-center ${attempt.passed ? 'bg-green-100' : 'bg-red-100'}`}>
                                            {attempt.passed ? (
                                                <CheckCircle className="h-5 w-5 text-green-600" />
                                            ) : (
                                                <XCircle className="h-5 w-5 text-red-600" />
                                            )}
                                        </div>
                                        <div>
                                            <div className="font-medium text-gray-900">{attempt.student}</div>
                                            <div className="text-sm text-gray-500">{attempt.quiz}</div>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-4">
                                        <div className="text-right">
                                            <div className={`font-bold ${attempt.passed ? 'text-green-600' : 'text-red-600'}`}>
                                                {attempt.score}%
                                            </div>
                                            <div className="text-xs text-gray-500">Pass: {attempt.passingScore}%</div>
                                        </div>
                                        <Badge variant={attempt.passed ? 'success' : 'destructive'}>
                                            {attempt.passed ? 'Passed' : 'Failed'}
                                        </Badge>
                                        <span className="text-xs text-gray-500">{attempt.completedAt}</span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>
            )}

            {/* Quizzes Table */}
            <Card>
                <CardHeader>
                    <CardTitle>All Quizzes</CardTitle>
                </CardHeader>
                <CardContent className="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[300px]">Quiz</TableHead>
                                <TableHead>Course</TableHead>
                                <TableHead>Lesson</TableHead>
                                <TableHead className="text-center">Questions</TableHead>
                                <TableHead className="text-center">Attempts</TableHead>
                                <TableHead className="text-center">Pass Score</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead className="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {quizzes.length > 0 ? quizzes.map((quiz) => (
                                <TableRow key={quiz.id}>
                                    <TableCell>
                                        <div className="flex items-center gap-3">
                                            <div className="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                                <HelpCircle className="h-5 w-5 text-amber-600" />
                                            </div>
                                            <div>
                                                <div className="font-medium text-gray-900">{quiz.title}</div>
                                                {quiz.timeLimit && (
                                                    <div className="text-xs text-gray-500">{quiz.timeLimit} min limit</div>
                                                )}
                                            </div>
                                        </div>
                                    </TableCell>
                                    <TableCell>
                                        <span className="text-sm text-gray-600">{quiz.course}</span>
                                    </TableCell>
                                    <TableCell>
                                        <span className="text-sm text-gray-600">{quiz.lesson}</span>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <Badge variant="secondary">{quiz.questionsCount}</Badge>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <div className="flex items-center justify-center gap-1 text-gray-600">
                                            <Users className="h-4 w-4" />
                                            <span>{quiz.attemptsCount}</span>
                                        </div>
                                    </TableCell>
                                    <TableCell className="text-center">
                                        <span className="text-sm font-medium">{quiz.passingScore}%</span>
                                    </TableCell>
                                    <TableCell>
                                        <Badge variant={quiz.isPublished ? 'success' : 'secondary'}>
                                            {quiz.isPublished ? 'Published' : 'Draft'}
                                        </Badge>
                                    </TableCell>
                                    <TableCell className="text-right">
                                        <Link href={route('teacher.questions')}>
                                            <Button variant="ghost" size="sm">
                                                <ExternalLink className="h-4 w-4 mr-1" />
                                                Questions
                                            </Button>
                                        </Link>
                                    </TableCell>
                                </TableRow>
                            )) : (
                                <TableRow>
                                    <TableCell colSpan={8} className="h-24 text-center text-gray-500">
                                        No quizzes found. Create quiz lessons in the curriculum builder.
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
