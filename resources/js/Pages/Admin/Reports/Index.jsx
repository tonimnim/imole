import React from 'react';
import { Head, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import {
    Users, BookOpen, GraduationCap, DollarSign, Award, Star, TrendingUp
} from 'lucide-react';

export default function Index({ userGrowth, enrollmentTrends, courseProgress, reviewStats, summary, period }) {
    const handlePeriodChange = (newPeriod) => {
        router.get(route('admin.reports.index'), { period: newPeriod }, { preserveState: true });
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-KE', {
            style: 'currency', currency: 'KES', minimumFractionDigits: 0,
        }).format(amount);
    };

    const summaryCards = [
        { title: 'Total Users', value: summary.total_users.toLocaleString(), subtext: `+${summary.new_users} new`, icon: Users, color: 'text-blue-600', bgColor: 'bg-blue-50' },
        { title: 'Total Courses', value: summary.total_courses.toLocaleString(), subtext: `${summary.published_courses} published`, icon: BookOpen, color: 'text-purple-600', bgColor: 'bg-purple-50' },
        { title: 'Enrollments', value: summary.total_enrollments.toLocaleString(), subtext: `+${summary.new_enrollments} new`, icon: GraduationCap, color: 'text-green-600', bgColor: 'bg-green-50' },
        { title: 'Revenue', value: formatCurrency(summary.total_revenue), subtext: `+${formatCurrency(summary.period_revenue)}`, icon: DollarSign, color: 'text-amber-600', bgColor: 'bg-amber-50' },
        { title: 'Certificates', value: summary.certificates_issued.toLocaleString(), subtext: 'Issued', icon: Award, color: 'text-pink-600', bgColor: 'bg-pink-50' },
        { title: 'Completion Rate', value: `${summary.completion_rate}%`, subtext: 'Courses completed', icon: TrendingUp, color: 'text-teal-600', bgColor: 'bg-teal-50' },
    ];

    const maxUsers = Math.max(...userGrowth.map(d => d.count), 1);
    const maxEnrollments = Math.max(...enrollmentTrends.map(d => d.count), 1);

    return (
        <AdminLayout>
            <Head title="Reports" />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">Reports</h1>
                        <p className="mt-1 text-gray-500">Platform analytics and insights</p>
                    </div>
                    <div className="flex gap-2">
                        {['7', '30', '90'].map((p) => (
                            <Button
                                key={p}
                                variant={period === p ? 'default' : 'outline'}
                                onClick={() => handlePeriodChange(p)}
                                size="sm"
                            >
                                {p} Days
                            </Button>
                        ))}
                    </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    {summaryCards.map((stat) => (
                        <Card key={stat.title} className="border-0 shadow-sm bg-white">
                            <CardContent className="p-4">
                                <div className={`p-2 rounded-lg ${stat.bgColor} w-fit mb-3`}>
                                    <stat.icon className={`h-5 w-5 ${stat.color}`} />
                                </div>
                                <p className="text-2xl font-bold text-gray-900">{stat.value}</p>
                                <p className="text-sm text-gray-500">{stat.title}</p>
                                <p className="text-xs text-green-600 mt-1">{stat.subtext}</p>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <CardTitle>User Growth</CardTitle>
                            <CardDescription>New registrations over time</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-48 flex items-end gap-1">
                                {userGrowth.map((day, index) => (
                                    <div key={index} className="flex-1 flex flex-col items-center">
                                        <div
                                            className="w-full bg-gradient-to-t from-blue-500 to-blue-400 rounded-t"
                                            style={{ height: `${(day.count / maxUsers) * 160}px`, minHeight: day.count > 0 ? '4px' : '0' }}
                                            title={`${day.date}: ${day.count} users`}
                                        />
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <CardTitle>Enrollment Trends</CardTitle>
                            <CardDescription>Course enrollments over time</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="h-48 flex items-end gap-1">
                                {enrollmentTrends.map((day, index) => (
                                    <div key={index} className="flex-1 flex flex-col items-center">
                                        <div
                                            className="w-full bg-gradient-to-t from-green-500 to-green-400 rounded-t"
                                            style={{ height: `${(day.count / maxEnrollments) * 160}px`, minHeight: day.count > 0 ? '4px' : '0' }}
                                            title={`${day.date}: ${day.count} enrollments`}
                                        />
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <CardTitle>Course Progress</CardTitle>
                            <CardDescription>Average student progress by course</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {courseProgress.map((course, index) => (
                                    <div key={index}>
                                        <div className="flex justify-between text-sm mb-1">
                                            <span className="font-medium truncate max-w-[200px]">{course.title}</span>
                                            <span className="text-gray-500">{course.average_progress}%</span>
                                        </div>
                                        <div className="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div
                                                className="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full"
                                                style={{ width: `${course.average_progress}%` }}
                                            />
                                        </div>
                                        <p className="text-xs text-gray-400 mt-1">{course.enrollments} students</p>
                                    </div>
                                ))}
                                {courseProgress.length === 0 && (
                                    <p className="text-gray-500 text-center py-4">No enrollment data</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <CardTitle>Review Statistics</CardTitle>
                            <CardDescription>Rating distribution</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="flex items-center gap-4 mb-6">
                                <div className="text-5xl font-bold text-amber-500">{reviewStats.average_rating}</div>
                                <div>
                                    <div className="flex items-center gap-1">
                                        {[...Array(5)].map((_, i) => (
                                            <Star key={i} className={`h-5 w-5 ${i < Math.round(reviewStats.average_rating) ? 'fill-amber-400 text-amber-400' : 'text-gray-300'}`} />
                                        ))}
                                    </div>
                                    <p className="text-sm text-gray-500 mt-1">{reviewStats.total} total reviews</p>
                                </div>
                            </div>
                            <div className="space-y-2">
                                {[5, 4, 3, 2, 1].map((rating) => {
                                    const count = reviewStats.distribution[rating] || 0;
                                    const percentage = reviewStats.total > 0 ? (count / reviewStats.total) * 100 : 0;
                                    return (
                                        <div key={rating} className="flex items-center gap-2">
                                            <span className="w-3 text-sm text-gray-600">{rating}</span>
                                            <Star className="h-4 w-4 fill-amber-400 text-amber-400" />
                                            <div className="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                                <div
                                                    className="h-full bg-amber-400 rounded-full"
                                                    style={{ width: `${percentage}%` }}
                                                />
                                            </div>
                                            <span className="w-12 text-sm text-gray-500 text-right">{count}</span>
                                        </div>
                                    );
                                })}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AdminLayout>
    );
}
