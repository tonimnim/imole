import React from 'react';
import { Head, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import {
    DollarSign, TrendingUp, TrendingDown, CreditCard, BookOpen
} from 'lucide-react';

export default function Index({ stats, dailyRevenue, topCourses, topTeachers, period }) {
    const handlePeriodChange = (newPeriod) => {
        router.get(route('admin.revenue.index'), { period: newPeriod }, { preserveState: true });
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-KE', {
            style: 'currency', currency: 'KES', minimumFractionDigits: 0,
        }).format(amount);
    };

    const statCards = [
        {
            title: 'Total Revenue',
            value: formatCurrency(stats.total_revenue),
            icon: DollarSign,
            color: 'text-green-600',
            bgColor: 'bg-green-50',
        },
        {
            title: `Last ${period} Days`,
            value: formatCurrency(stats.period_revenue),
            icon: TrendingUp,
            color: 'text-blue-600',
            bgColor: 'bg-blue-50',
            change: stats.revenue_growth,
        },
        {
            title: 'Total Transactions',
            value: stats.total_transactions.toLocaleString(),
            icon: CreditCard,
            color: 'text-purple-600',
            bgColor: 'bg-purple-50',
        },
        {
            title: `Period Transactions`,
            value: stats.period_transactions.toLocaleString(),
            icon: CreditCard,
            color: 'text-amber-600',
            bgColor: 'bg-amber-50',
        },
    ];

    const maxRevenue = Math.max(...dailyRevenue.map(d => d.revenue), 1);

    return (
        <AdminLayout>
            <Head title="Revenue" />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">Revenue</h1>
                        <p className="mt-1 text-gray-500">Financial analytics and insights</p>
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
                                        <div className="flex items-center gap-2">
                                            <p className="text-sm text-gray-500">{stat.title}</p>
                                            {stat.change !== undefined && (
                                                <span className={`text-xs flex items-center ${stat.change >= 0 ? 'text-green-600' : 'text-red-600'}`}>
                                                    {stat.change >= 0 ? <TrendingUp className="h-3 w-3" /> : <TrendingDown className="h-3 w-3" />}
                                                    {Math.abs(stat.change)}%
                                                </span>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                <Card className="border-0 shadow-sm bg-white">
                    <CardHeader>
                        <CardTitle>Daily Revenue</CardTitle>
                        <CardDescription>Revenue trend over the selected period</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="h-64 flex items-end gap-1">
                            {dailyRevenue.map((day, index) => (
                                <div key={index} className="flex-1 flex flex-col items-center">
                                    <div
                                        className="w-full bg-gradient-to-t from-amber-500 to-amber-400 rounded-t"
                                        style={{ height: `${(day.revenue / maxRevenue) * 200}px`, minHeight: day.revenue > 0 ? '4px' : '0' }}
                                        title={`${day.date}: ${formatCurrency(day.revenue)}`}
                                    />
                                    {dailyRevenue.length <= 14 && (
                                        <span className="text-xs text-gray-400 mt-2 rotate-45 origin-left">{day.date}</span>
                                    )}
                                </div>
                            ))}
                        </div>
                    </CardContent>
                </Card>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <CardTitle>Top Earning Courses</CardTitle>
                            <CardDescription>By revenue in selected period</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {topCourses.map((course, index) => (
                                    <div key={index} className="flex items-center gap-4">
                                        <div className="h-8 w-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                                            {index + 1}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <p className="font-medium text-gray-900 truncate">{course.course}</p>
                                            <p className="text-sm text-gray-500">{course.sales} sales</p>
                                        </div>
                                        <p className="font-bold text-green-600">{formatCurrency(course.revenue)}</p>
                                    </div>
                                ))}
                                {topCourses.length === 0 && (
                                    <p className="text-gray-500 text-center py-4">No data for this period</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <CardTitle>Top Earning Teachers</CardTitle>
                            <CardDescription>By total course revenue</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {topTeachers.map((teacher, index) => (
                                    <div key={index} className="flex items-center gap-4">
                                        <div className="h-8 w-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-sm">
                                            {index + 1}
                                        </div>
                                        {teacher.avatar ? (
                                            <img src={teacher.avatar} className="h-10 w-10 rounded-full object-cover" />
                                        ) : (
                                            <div className="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-medium">
                                                {teacher.name.charAt(0)}
                                            </div>
                                        )}
                                        <div className="flex-1 min-w-0">
                                            <p className="font-medium text-gray-900 truncate">{teacher.name}</p>
                                            <p className="text-sm text-gray-500">{teacher.courses} courses</p>
                                        </div>
                                        <p className="font-bold text-green-600">{formatCurrency(teacher.revenue)}</p>
                                    </div>
                                ))}
                                {topTeachers.length === 0 && (
                                    <p className="text-gray-500 text-center py-4">No data for this period</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AdminLayout>
    );
}
