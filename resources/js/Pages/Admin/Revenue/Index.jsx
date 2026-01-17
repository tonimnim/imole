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
import { Tabs, TabsContent, TabsList, TabsTrigger } from '../../../components/ui/tabs';
import { Progress } from '../../../components/ui/progress';
import {
    AreaChart, Area, BarChart, Bar, LineChart, Line, XAxis, YAxis,
    CartesianGrid, Tooltip, ResponsiveContainer, PieChart, Pie, Cell
} from 'recharts';
import {
    DollarSign, TrendingUp, TrendingDown, CreditCard, BookOpen,
    Users, Download, Calendar, ArrowUpRight, ArrowDownRight,
    Wallet, Target, Award
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
        }).format(amount);
    };

    const formatCompactCurrency = (value) => {
        if (value >= 1000000) return `${(value / 1000000).toFixed(1)}M`;
        if (value >= 1000) return `${(value / 1000).toFixed(1)}K`;
        return value.toString();
    };

    const CustomTooltip = ({ active, payload, label }) => {
        if (active && payload && payload.length) {
            return (
                <div className="bg-white p-3 shadow-lg rounded-lg border">
                    <p className="font-medium text-gray-900">{label}</p>
                    <p className="text-emerald-600 font-bold">
                        {formatCurrency(payload[0].value)}
                    </p>
                    {payload[0].payload.transactions && (
                        <p className="text-gray-500 text-sm">
                            {payload[0].payload.transactions} transactions
                        </p>
                    )}
                </div>
            );
        }
        return null;
    };

    const statCards = [
        {
            title: 'Total Revenue',
            value: formatCurrency(stats.total_revenue),
            icon: DollarSign,
            color: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-100',
            description: 'All-time earnings'
        },
        {
            title: `${period}-Day Revenue`,
            value: formatCurrency(stats.period_revenue),
            icon: TrendingUp,
            color: 'text-blue-600',
            bgColor: 'bg-blue-50',
            borderColor: 'border-blue-100',
            change: stats.revenue_growth,
            description: 'Selected period'
        },
        {
            title: 'Total Transactions',
            value: stats.total_transactions.toLocaleString(),
            icon: CreditCard,
            color: 'text-purple-600',
            bgColor: 'bg-purple-50',
            borderColor: 'border-purple-100',
            description: 'Completed payments'
        },
        {
            title: 'Period Transactions',
            value: stats.period_transactions.toLocaleString(),
            icon: Wallet,
            color: 'text-amber-600',
            bgColor: 'bg-amber-50',
            borderColor: 'border-amber-100',
            description: 'In selected period'
        },
    ];

    // Calculate average daily revenue
    const avgDailyRevenue = dailyRevenue.length > 0
        ? stats.period_revenue / dailyRevenue.length
        : 0;

    // Find best performing day
    const bestDay = dailyRevenue.reduce((max, day) =>
        day.revenue > (max?.revenue || 0) ? day : max, null);

    // Colors for pie chart
    const COLORS = ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6'];

    return (
        <AdminLayout>
            <Head title="Revenue Analytics" />

            <div className="space-y-6">
                {/* Page Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">Revenue Analytics</h1>
                        <p className="mt-1 text-gray-500">Financial insights and performance metrics</p>
                    </div>
                    <div className="flex items-center gap-3">
                        <Select value={period} onValueChange={handlePeriodChange}>
                            <SelectTrigger className="w-[140px]">
                                <Calendar className="h-4 w-4 mr-2" />
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
                    {statCards.map((stat) => (
                        <Card key={stat.title} className={`border ${stat.borderColor} shadow-sm bg-white hover:shadow-md transition-shadow`}>
                            <CardContent className="p-5">
                                <div className="flex items-start justify-between">
                                    <div className="flex-1">
                                        <p className="text-sm font-medium text-gray-500">{stat.title}</p>
                                        <div className="flex items-baseline gap-2 mt-1">
                                            <p className="text-2xl font-bold text-gray-900">{stat.value}</p>
                                            {stat.change !== undefined && (
                                                <span className={`text-xs font-medium flex items-center ${stat.change >= 0 ? 'text-emerald-600' : 'text-red-600'}`}>
                                                    {stat.change >= 0 ? (
                                                        <ArrowUpRight className="h-3 w-3" />
                                                    ) : (
                                                        <ArrowDownRight className="h-3 w-3" />
                                                    )}
                                                    {Math.abs(stat.change)}%
                                                </span>
                                            )}
                                        </div>
                                        <p className="text-xs text-gray-400 mt-1">{stat.description}</p>
                                    </div>
                                    <div className={`p-3 rounded-xl ${stat.bgColor}`}>
                                        <stat.icon className={`h-5 w-5 ${stat.color}`} />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {/* Revenue Chart */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardHeader>
                        <div className="flex items-center justify-between">
                            <div>
                                <CardTitle className="text-lg">Revenue Overview</CardTitle>
                                <CardDescription>Daily revenue for the last {period} days</CardDescription>
                            </div>
                            <div className="flex items-center gap-4 text-sm">
                                <div className="flex items-center gap-2">
                                    <div className="h-3 w-3 rounded-full bg-emerald-500"></div>
                                    <span className="text-gray-600">Revenue</span>
                                </div>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div className="h-80">
                            <ResponsiveContainer width="100%" height="100%">
                                <AreaChart data={dailyRevenue} margin={{ top: 10, right: 30, left: 0, bottom: 0 }}>
                                    <defs>
                                        <linearGradient id="colorRevenue" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="5%" stopColor="#10b981" stopOpacity={0.3}/>
                                            <stop offset="95%" stopColor="#10b981" stopOpacity={0}/>
                                        </linearGradient>
                                    </defs>
                                    <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
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
                                        stroke="#10b981"
                                        strokeWidth={2}
                                        fillOpacity={1}
                                        fill="url(#colorRevenue)"
                                    />
                                </AreaChart>
                            </ResponsiveContainer>
                        </div>
                    </CardContent>
                </Card>

                {/* Quick Stats */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <Card className="border-0 shadow-sm bg-gradient-to-br from-emerald-500 to-teal-600 text-white">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-emerald-100 text-sm">Average Daily</p>
                                    <p className="text-2xl font-bold mt-1">{formatCurrency(avgDailyRevenue)}</p>
                                </div>
                                <Target className="h-10 w-10 text-white/30" />
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-0 shadow-sm bg-gradient-to-br from-blue-500 to-indigo-600 text-white">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-blue-100 text-sm">Best Day</p>
                                    <p className="text-2xl font-bold mt-1">
                                        {bestDay ? formatCurrency(bestDay.revenue) : 'N/A'}
                                    </p>
                                    {bestDay && <p className="text-blue-200 text-xs mt-1">{bestDay.date}</p>}
                                </div>
                                <Award className="h-10 w-10 text-white/30" />
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-0 shadow-sm bg-gradient-to-br from-purple-500 to-pink-600 text-white">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-purple-100 text-sm">Growth</p>
                                    <p className="text-2xl font-bold mt-1">
                                        {stats.revenue_growth >= 0 ? '+' : ''}{stats.revenue_growth}%
                                    </p>
                                    <p className="text-purple-200 text-xs mt-1">vs previous period</p>
                                </div>
                                {stats.revenue_growth >= 0 ? (
                                    <TrendingUp className="h-10 w-10 text-white/30" />
                                ) : (
                                    <TrendingDown className="h-10 w-10 text-white/30" />
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Top Courses & Teachers */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Top Earning Courses */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <div className="flex items-center justify-between">
                                <div>
                                    <CardTitle className="text-lg flex items-center gap-2">
                                        <BookOpen className="h-5 w-5 text-amber-500" />
                                        Top Earning Courses
                                    </CardTitle>
                                    <CardDescription>Best performing courses by revenue</CardDescription>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent>
                            {topCourses.length > 0 ? (
                                <div className="space-y-4">
                                    {topCourses.map((course, index) => {
                                        const maxRevenue = topCourses[0]?.revenue || 1;
                                        const percentage = (course.revenue / maxRevenue) * 100;

                                        return (
                                            <div key={index} className="space-y-2">
                                                <div className="flex items-center gap-3">
                                                    <div className={`h-8 w-8 rounded-full flex items-center justify-center font-bold text-sm ${
                                                        index === 0 ? 'bg-amber-100 text-amber-700' :
                                                        index === 1 ? 'bg-gray-100 text-gray-700' :
                                                        index === 2 ? 'bg-orange-100 text-orange-700' :
                                                        'bg-gray-50 text-gray-500'
                                                    }`}>
                                                        {index + 1}
                                                    </div>
                                                    <div className="flex-1 min-w-0">
                                                        <p className="font-medium text-gray-900 truncate text-sm">
                                                            {course.course}
                                                        </p>
                                                        <p className="text-xs text-gray-500">
                                                            {course.sales} sales
                                                        </p>
                                                    </div>
                                                    <p className="font-bold text-emerald-600 text-sm">
                                                        {formatCurrency(course.revenue)}
                                                    </p>
                                                </div>
                                                <div className="ml-11">
                                                    <div className="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                        <div
                                                            className="h-full bg-gradient-to-r from-amber-400 to-amber-500 rounded-full transition-all"
                                                            style={{ width: `${percentage}%` }}
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        );
                                    })}
                                </div>
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <BookOpen className="h-10 w-10 mx-auto mb-2 opacity-30" />
                                    <p className="font-medium">No course data</p>
                                    <p className="text-sm">Revenue data will appear here</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    {/* Top Earning Teachers */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <div className="flex items-center justify-between">
                                <div>
                                    <CardTitle className="text-lg flex items-center gap-2">
                                        <Users className="h-5 w-5 text-emerald-500" />
                                        Top Earning Teachers
                                    </CardTitle>
                                    <CardDescription>Instructors by total revenue</CardDescription>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent>
                            {topTeachers.length > 0 ? (
                                <div className="space-y-4">
                                    {topTeachers.map((teacher, index) => {
                                        const maxRevenue = topTeachers[0]?.revenue || 1;
                                        const percentage = (teacher.revenue / maxRevenue) * 100;

                                        return (
                                            <div key={index} className="space-y-2">
                                                <div className="flex items-center gap-3">
                                                    <div className="relative">
                                                        {teacher.avatar ? (
                                                            <img
                                                                src={teacher.avatar}
                                                                alt={teacher.name}
                                                                className="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm"
                                                            />
                                                        ) : (
                                                            <div className="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold shadow-sm">
                                                                {teacher.name.charAt(0)}
                                                            </div>
                                                        )}
                                                        {index < 3 && (
                                                            <div className={`absolute -top-1 -right-1 h-5 w-5 rounded-full flex items-center justify-center text-xs font-bold ${
                                                                index === 0 ? 'bg-amber-400 text-amber-900' :
                                                                index === 1 ? 'bg-gray-300 text-gray-700' :
                                                                'bg-orange-300 text-orange-800'
                                                            }`}>
                                                                {index + 1}
                                                            </div>
                                                        )}
                                                    </div>
                                                    <div className="flex-1 min-w-0">
                                                        <p className="font-medium text-gray-900 truncate text-sm">
                                                            {teacher.name}
                                                        </p>
                                                        <p className="text-xs text-gray-500">
                                                            {teacher.courses} {teacher.courses === 1 ? 'course' : 'courses'}
                                                        </p>
                                                    </div>
                                                    <p className="font-bold text-emerald-600 text-sm">
                                                        {formatCurrency(teacher.revenue)}
                                                    </p>
                                                </div>
                                                <div className="ml-13 pl-10">
                                                    <div className="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                        <div
                                                            className="h-full bg-gradient-to-r from-emerald-400 to-emerald-500 rounded-full transition-all"
                                                            style={{ width: `${percentage}%` }}
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        );
                                    })}
                                </div>
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <Users className="h-10 w-10 mx-auto mb-2 opacity-30" />
                                    <p className="font-medium">No teacher data</p>
                                    <p className="text-sm">Revenue data will appear here</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>

                {/* Transactions Chart */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardHeader>
                        <CardTitle className="text-lg">Daily Transactions</CardTitle>
                        <CardDescription>Number of successful transactions per day</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="h-64">
                            <ResponsiveContainer width="100%" height="100%">
                                <BarChart data={dailyRevenue} margin={{ top: 10, right: 30, left: 0, bottom: 0 }}>
                                    <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" vertical={false} />
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
                                    />
                                    <Tooltip
                                        contentStyle={{
                                            backgroundColor: 'white',
                                            border: '1px solid #e5e7eb',
                                            borderRadius: '8px',
                                            boxShadow: '0 4px 6px -1px rgb(0 0 0 / 0.1)'
                                        }}
                                        formatter={(value) => [value, 'Transactions']}
                                    />
                                    <Bar
                                        dataKey="transactions"
                                        fill="#8b5cf6"
                                        radius={[4, 4, 0, 0]}
                                    />
                                </BarChart>
                            </ResponsiveContainer>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AdminLayout>
    );
}
