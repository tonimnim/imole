import React from 'react';
import { Head, Link } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent } from '../../../components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../../../components/ui/table';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { HelpCircle, CheckSquare, ToggleLeft, MessageSquare, Plus } from 'lucide-react';

const QUESTION_TYPES = {
    multiple_choice: { label: 'Multiple Choice', icon: CheckSquare, color: 'bg-blue-100 text-blue-600' },
    true_false: { label: 'True/False', icon: ToggleLeft, color: 'bg-green-100 text-green-600' },
    short_answer: { label: 'Short Answer', icon: MessageSquare, color: 'bg-purple-100 text-purple-600' },
};

export default function QuestionsIndex({ questions, stats }) {
    return (
        <TeacherLayout>
            <Head title="Question Bank" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Question Bank</h1>
                    <p className="mt-1 text-gray-500">All quiz questions across your courses.</p>
                </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Total Questions</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold">{stats.total}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Multiple Choice</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-blue-600">{stats.multipleChoice}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">True/False</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-green-600">{stats.trueFalse}</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader className="pb-2">
                        <CardTitle className="text-sm font-medium text-gray-500">Short Answer</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="text-2xl font-bold text-purple-600">{stats.shortAnswer}</div>
                    </CardContent>
                </Card>
            </div>

            {/* Questions Table */}
            <Card>
                <CardHeader>
                    <CardTitle>All Questions</CardTitle>
                </CardHeader>
                <CardContent className="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[400px]">Question</TableHead>
                                <TableHead>Quiz</TableHead>
                                <TableHead>Course</TableHead>
                                <TableHead className="text-center">Type</TableHead>
                                <TableHead className="text-center">Points</TableHead>
                                <TableHead>Created</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {questions.length > 0 ? questions.map((question) => {
                                const typeConfig = QUESTION_TYPES[question.type] || QUESTION_TYPES.multiple_choice;
                                const TypeIcon = typeConfig.icon;
                                return (
                                    <TableRow key={question.id}>
                                        <TableCell>
                                            <div className="flex items-start gap-3">
                                                <div className={`h-10 w-10 rounded-lg flex items-center justify-center shrink-0 ${typeConfig.color}`}>
                                                    <TypeIcon className="h-5 w-5" />
                                                </div>
                                                <div className="min-w-0">
                                                    <div className="font-medium text-gray-900 line-clamp-2">
                                                        {question.question}
                                                    </div>
                                                </div>
                                            </div>
                                        </TableCell>
                                        <TableCell>
                                            <span className="text-sm text-gray-600">{question.quiz}</span>
                                        </TableCell>
                                        <TableCell>
                                            <span className="text-sm text-gray-600">{question.course}</span>
                                        </TableCell>
                                        <TableCell className="text-center">
                                            <Badge variant="secondary" className={typeConfig.color}>
                                                {typeConfig.label}
                                            </Badge>
                                        </TableCell>
                                        <TableCell className="text-center">
                                            <Badge variant="secondary">{question.points} pts</Badge>
                                        </TableCell>
                                        <TableCell>
                                            <span className="text-sm text-gray-500">{question.createdAt}</span>
                                        </TableCell>
                                    </TableRow>
                                );
                            }) : (
                                <TableRow>
                                    <TableCell colSpan={6} className="h-24 text-center text-gray-500">
                                        <div className="flex flex-col items-center gap-2">
                                            <HelpCircle className="h-8 w-8 text-gray-300" />
                                            <p>No questions found. Create quiz lessons and add questions.</p>
                                        </div>
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
