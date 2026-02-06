import React from 'react';
import { Head, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '../../../components/ui/select';
import {
    AreaChart, Area, BarChart, Bar, XAxis, YAxis,
    CartesianGrid, Tooltip, ResponsiveContainer
} from 'recharts';
import {
    DollarSign, TrendingUp, TrendingDown, CreditCard, BookOpen,
    Users, Download, Calendar, ArrowUpRight, ArrowDownRight
} from 'lucide-react';

export default function Index({ stats, dailyRevenue, topCourses, topTeachers, period }) {
    const handlePeriodChange = (newPeriod) => {
        router.get(route('admin.revenue.index'), { period: newPeriod }, { preserveState: true });
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-KE', {
            style: 'currency',
            currency: 'KES',
            minimumFractionDigits: 0,
        }).format(amount || 0);
    };

    const formatCompactCurrency = (value) => {
        if (value >= 1000000) return `${(value / 1000000).toFixed(1)}M`;
        if (value >= 1000) return `${(value / 1000).toFixed(1)}K`;
        return value?.toString() || '0';
    };

    const CustomTooltip = ({ active, payload, label }) => {
        if (active && payload && payload.length) {
            return (
                <div className="bg-white p-3 shadow-lg rounded-lg border border-gray-200">
                    <p className="font-medium text-gray-900">{label}</p>
                    <p className="text-amber-600 font-bold">
                        {formatCurrency(payload[0].value)}
                    </p>
                    {payload[0].payload.transactions && (
                        <p className="text-gray-500 text-sm">
                            {payload[0].payload.transactions} enrollments
                        </p>
                    )}
                </div>
            );
        }
        return null;
    };

    const avgDailyRevenue = dailyRevenue.length > 0
        ? stats.period_revenue / dailyRevenue.length
        : 0;

    const bestDay = dailyRevenue.reduce((max, day) =>
        day.revenue > (max?.revenue || 0) ? day : max, null);

    return (
        <AdminLayout>
            <Head title="Revenue Analytics" />

            <div className="space-y-6">
                {/* Page Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Revenue Analytics</h1>
                        <p className="text-gray-600">Financial insights and performance metrics</p>
                    </div>
                    <div className="flex items-center gap-3">
                        <Select value={period} onValueChange={handlePeriodChange}>
                            <SelectTrigger className="w-[140px] bg-white">
                                <Calendar className="h-4 w-4 mr-2 text-gray-500" />
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="7">Last 7 days</SelectItem>
                                <SelectItem value="30">Last 30 days</SelectItem>
                                <SelectItem value="90">Last 90 days</SelectItem>
                            </SelectContent>
                        </Select>
                        <Button variant="outline" size="sm">
                            <Download className="h-4 w-4 mr-2" />
                            Export
                        </Button>
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600">Total Revenue</p>
                                    <p className="text-2xl font-bold text-gray-900 mt-1">
                                        {formatCurrency(stats.total_revenue)}
                                    </p>
                                    <p className="text-xs text-gray-500 mt-1">All-time earnings</p>
                                </div>
                                <div className="p-3 bg-amber-50 rounded-lg">
                                    <DollarSign className="h-5 w-5 text-amber-600" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600">{period}-Day Revenue</p>
                                    <div className="flex items-baseline gap-2 mt-1">
                                        <p className="text-2xl font-bold text-gray-900">
                                            {formatCurrency(stats.period_revenue)}
                                        </p>
                                        {stats.revenue_growth !== 0 && (
                                            <span className={`text-xs font-medium flex items-center ${stats.revenue_growth >= 0 ? 'text-green-600' : 'text-red-600'}`}>
                                                {stats.revenue_growth >= 0 ? <ArrowUpRight className="h-3 w-3" /> : <ArrowDownRight className="h-3 w-3" />}
                                                {Math.abs(stats.revenue_growth)}%
                                            </span>
                                        )}
                                    </div>
                                    <p className="text-xs text-gray-500 mt-1">Selected period</p>
                                </div>
                                <div className="p-3 bg-blue-50 rounded-lg">
                                    <TrendingUp className="h-5 w-5 text-blue-600" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600">Total Enrollments</p>
                                    <p className="text-2xl font-bold text-gray-900 mt-1">
                                        {stats.total_transactions.toLocaleString()}
                                    </p>
                                    <p className="text-xs text-gray-500 mt-1">All-time</p>
                                </div>
                                <div className="p-3 bg-purple-50 rounded-lg">
                                    <CreditCard className="h-5 w-5 text-purple-600" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600">Period Enrollments</p>
                                    <p className="text-2xl font-bold text-gray-900 mt-1">
                                        {stats.period_transactions.toLocaleString()}
                                    </p>
                                    <p className="text-xs text-gray-500 mt-1">In selected period</p>
                                </div>
                                <div className="p-3 bg-gray-100 rounded-lg">
                                    <Users className="h-5 w-5 text-gray-600" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Revenue Chart */}
                <Card className="bg-white border border-gray-200">
                    <CardHeader>
                        <CardTitle className="text-lg text-gray-900">Revenue Overview</CardTitle>
                        <CardDescription className="text-gray-600">
                            Daily revenue for the last {period} days
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="h-72">
                            {dailyRevenue.length > 0 ? (
                                <ResponsiveContainer width="100%" height="100%">
                                    <AreaChart data={dailyRevenue} margin={{ top: 10, right: 30, left: 0, bottom: 0 }}>
                                        <defs>
                                            <linearGradient id="colorRevenue" x1="0" y1="0" x2="0" y2="1">
                                                <stop offset="5%" stopColor="#f59e0b" stopOpacity={0.2}/>
                                                <stop offset="95%" stopColor="#f59e0b" stopOpacity={0}/>
                                            </linearGradient>
                                        </defs>
                                        <CartesianGrid strokeDasharray="3 3" stroke="#e5e7eb" />
                                        <XAxis
                                            dataKey="date"
                                            axisLine={false}
                                            tickLine={false}
                                            tick={{ fill: '#6b7280', fontSize: 12 }}
                                        />
                                        <YAxis
                                            axisLine={false}
                                            tickLine={false}
                                            tick={{ fill: '#6b7280', fontSize: 12 }}
                                            tickFormatter={formatCompactCurrency}
                                        />
                                        <Tooltip content={<CustomTooltip />} />
                                        <Area
                                            type="monotone"
                                            dataKey="revenue"
                                            stroke="#f59e0b"
                                            strokeWidth={2}
                                            fillOpacity={1}
                                            fill="url(#colorRevenue)"
                                        />
                                    </AreaChart>
                                </ResponsiveContainer>
                            ) : (
                                <div className="h-full flex items-center justify-center text-gray-500">
                                    <div className="text-center">
                                        <DollarSign className="h-10 w-10 mx-auto mb-2 opacity-30" />
                                        <p>No revenue data for this period</p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </CardContent>
                </Card>

                {/* Summary Stats */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <p className="text-sm text-gray-600">Average Daily Revenue</p>
                            <p className="text-xl font-bold text-gray-900 mt-1">
                                {formatCurrency(avgDailyRevenue)}
                            </p>
                        </CardContent>
                    </Card>

                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <p className="text-sm text-gray-600">Best Performing Day</p>
                            <p className="text-xl font-bold text-gray-900 mt-1">
                                {bestDay ? formatCurrency(bestDay.revenue) : 'N/A'}
                            </p>
                            {bestDay && <p className="text-xs text-gray-500 mt-1">{bestDay.date}</p>}
                        </CardContent>
                    </Card>

                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <p className="text-sm text-gray-600">Growth vs Previous Period</p>
                            <p className={`text-xl font-bold mt-1 ${stats.revenue_growth >= 0 ? 'text-green-600' : 'text-red-600'}`}>
                                {stats.revenue_growth >= 0 ? '+' : ''}{stats.revenue_growth}%
                            </p>
                        </CardContent>
                    </Card>
                </div>

                {/* Top Courses & Teachers */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <Card className="bg-white border border-gray-200">
                        <CardHeader>
                            <CardTitle className="text-lg text-gray-900 flex items-center gap-2">
                                <BookOpen className="h-5 w-5 text-amber-500" />
                                Top Earning Courses
                            </CardTitle>
                            <CardDescription className="text-gray-600">
                                Best performing courses by revenue
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            {topCourses.length > 0 ? (
                                <div className="space-y-4">
                                    {topCourses.map((course, index) => (
                                        <div key={index} className="flex items-center gap-3">
                                            <div className="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-sm font-medium text-gray-700">
                                                {index + 1}
                                            </div>
                                            <div className="flex-1 min-w-0">
                                                <p className="font-medium text-gray-900 truncate text-sm">
                                                    {course.course}
                                                </p>
                                                <p className="text-xs text-gray-500">{course.sales} sales</p>
                                            </div>
                                            <p className="font-semibold text-gray-900 text-sm">
                                                {formatCurrency(course.revenue)}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <BookOpen className="h-10 w-10 mx-auto mb-2 opacity-30" />
                                    <p className="font-medium text-gray-700">No course data</p>
                                    <p className="text-sm text-gray-500">Revenue data will appear here</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    <Card className="bg-white border border-gray-200">
                        <CardHeader>
                            <CardTitle className="text-lg text-gray-900 flex items-center gap-2">
                                <Users className="h-5 w-5 text-amber-500" />
                                Top Earning Teachers
                            </CardTitle>
                            <CardDescription className="text-gray-600">
                                Instructors by total revenue
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            {topTeachers.length > 0 ? (
                                <div className="space-y-4">
                                    {topTeachers.map((teacher, index) => (
                                        <div key={index} className="flex items-center gap-3">
                                            {teacher.avatar ? (
                                                <img
                                                    src={teacher.avatar}
                                                    alt={teacher.name}
                                                    className="h-9 w-9 rounded-full object-cover"
                                                />
                                            ) : (
                                                <div className="h-9 w-9 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 font-medium text-sm">
                                                    {teacher.name.charAt(0)}
                                                </div>
                                            )}
                                            <div className="flex-1 min-w-0">
                                                <p className="font-medium text-gray-900 truncate text-sm">
                                                    {teacher.name}
                                                </p>
                                                <p className="text-xs text-gray-500">
                                                    {teacher.courses} {teacher.courses === 1 ? 'course' : 'courses'}
                                                </p>
                                            </div>
                                            <p className="font-semibold text-gray-900 text-sm">
                                                {formatCurrency(teacher.revenue)}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <Users className="h-10 w-10 mx-auto mb-2 opacity-30" />
                                    <p className="font-medium text-gray-700">No teacher data</p>
                                    <p className="text-sm text-gray-500">Revenue data will appear here</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AdminLayout>
    );
}
