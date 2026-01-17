import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../../components/ui/card';
import { Badge } from '../../components/ui/badge';
import {
    LineChart,
    Line,
    XAxis,
    YAxis,
    CartesianGrid,
    Tooltip,
    Legend,
    ResponsiveContainer,
} from 'recharts';
import {
    Users,
    BookOpen,
    GraduationCap,
    CreditCard,
    Award,
    TrendingUp,
    TrendingDown,
    UserPlus,
    DollarSign,
    Star,
    ArrowUpRight,
    ArrowRight
} from 'lucide-react';

export default function Dashboard({
    stats,
    monthlyStats,
    recentUsers,
    recentEnrollments,
    recentPayments,
    topCourses,
    topTeachers,
    pendingReviews
}) {
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-KE', {
            style: 'currency',
            currency: 'KES',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    const statCards = [
        {
            title: 'Total Users',
            value: stats.total_users.toLocaleString(),
            description: `${stats.total_teachers} teachers, ${stats.total_students} students`,
            icon: Users,
            color: 'text-blue-600',
            bgColor: 'bg-blue-50',
        },
        {
            title: 'Total Courses',
            value: stats.total_courses.toLocaleString(),
            description: `${stats.published_courses} published`,
            icon: BookOpen,
            color: 'text-purple-600',
            bgColor: 'bg-purple-50',
        },
        {
            title: 'Total Enrollments',
            value: stats.total_enrollments.toLocaleString(),
            description: 'Active course enrollments',
            icon: GraduationCap,
            color: 'text-green-600',
            bgColor: 'bg-green-50',
        },
        {
            title: 'Total Revenue',
            value: formatCurrency(stats.total_revenue),
            description: 'From completed payments',
            icon: DollarSign,
            color: 'text-amber-600',
            bgColor: 'bg-amber-50',
        },
        {
            title: 'Certificates Issued',
            value: stats.total_certificates.toLocaleString(),
            description: 'Course completions',
            icon: Award,
            color: 'text-pink-600',
            bgColor: 'bg-pink-50',
        },
    ];

    return (
        <AdminLayout>
            <Head title="Admin Dashboard" />

            <div className="space-y-8">
                {/* Header */}
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p className="mt-1 text-gray-500">Platform overview and analytics</p>
                </div>

                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    {statCards.map((stat) => (
                        <Card key={stat.title} className="border-0 shadow-sm bg-white">
                            <CardContent className="p-6">
                                <div className="flex items-center justify-between">
                                    <div className={`p-2 rounded-lg ${stat.bgColor}`}>
                                        <stat.icon className={`h-5 w-5 ${stat.color}`} />
                                    </div>
                                </div>
                                <div className="mt-4">
                                    <p className="text-2xl font-bold text-gray-900">{stat.value}</p>
                                    <p className="text-sm text-gray-500">{stat.title}</p>
                                    <p className="text-xs text-gray-400 mt-1">{stat.description}</p>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                {/* Charts Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Users & Enrollments Trend */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <CardTitle className="text-gray-900">Users & Enrollments</CardTitle>
                            <CardDescription className="text-gray-500">Monthly growth trends</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <ResponsiveContainer width="100%" height={280}>
                                <LineChart data={monthlyStats} margin={{ top: 5, right: 20, left: 0, bottom: 5 }}>
                                    <CartesianGrid strokeDasharray="3 3" stroke="#e5e7eb" />
                                    <XAxis
                                        dataKey="month"
                                        tick={{ fill: '#6b7280', fontSize: 12 }}
                                        axisLine={{ stroke: '#e5e7eb' }}
                                    />
                                    <YAxis
                                        tick={{ fill: '#6b7280', fontSize: 12 }}
                                        axisLine={{ stroke: '#e5e7eb' }}
                                    />
                                    <Tooltip
                                        contentStyle={{
                                            backgroundColor: '#fff',
                                            border: '1px solid #e5e7eb',
                                            borderRadius: '8px',
                                            boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)'
                                        }}
                                        labelStyle={{ color: '#111827', fontWeight: 600 }}
                                    />
                                    <Legend
                                        wrapperStyle={{ paddingTop: '20px' }}
                                        iconType="circle"
                                    />
                                    <Line
                                        type="monotone"
                                        dataKey="users"
                                        name="New Users"
                                        stroke="#3b82f6"
                                        strokeWidth={2}
                                        dot={{ fill: '#3b82f6', strokeWidth: 2, r: 4 }}
                                        activeDot={{ r: 6, fill: '#3b82f6' }}
                                    />
                                    <Line
                                        type="monotone"
                                        dataKey="enrollments"
                                        name="Enrollments"
                                        stroke="#22c55e"
                                        strokeWidth={2}
                                        dot={{ fill: '#22c55e', strokeWidth: 2, r: 4 }}
                                        activeDot={{ r: 6, fill: '#22c55e' }}
                                    />
                                </LineChart>
                            </ResponsiveContainer>
                        </CardContent>
                    </Card>

                    {/* Revenue Trend */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <CardTitle className="text-gray-900">Revenue Trend</CardTitle>
                            <CardDescription className="text-gray-500">Monthly revenue over time</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <ResponsiveContainer width="100%" height={280}>
                                <LineChart data={monthlyStats} margin={{ top: 5, right: 20, left: 10, bottom: 5 }}>
                                    <CartesianGrid strokeDasharray="3 3" stroke="#e5e7eb" />
                                    <XAxis
                                        dataKey="month"
                                        tick={{ fill: '#6b7280', fontSize: 12 }}
                                        axisLine={{ stroke: '#e5e7eb' }}
                                    />
                                    <YAxis
                                        tick={{ fill: '#6b7280', fontSize: 12 }}
                                        axisLine={{ stroke: '#e5e7eb' }}
                                        tickFormatter={(value) => {
                                            if (value >= 1000000) return `Ksh ${(value / 1000000).toFixed(1)}M`;
                                            if (value >= 1000) return `Ksh ${(value / 1000).toFixed(0)}K`;
                                            return `Ksh ${value}`;
                                        }}
                                    />
                                    <Tooltip
                                        contentStyle={{
                                            backgroundColor: '#fff',
                                            border: '1px solid #e5e7eb',
                                            borderRadius: '8px',
                                            boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)'
                                        }}
                                        labelStyle={{ color: '#111827', fontWeight: 600 }}
                                        formatter={(value) => [formatCurrency(value), 'Revenue']}
                                    />
                                    <Legend
                                        wrapperStyle={{ paddingTop: '20px' }}
                                        iconType="circle"
                                    />
                                    <Line
                                        type="monotone"
                                        dataKey="revenue"
                                        name="Revenue"
                                        stroke="#f59e0b"
                                        strokeWidth={2}
                                        dot={{ fill: '#f59e0b', strokeWidth: 2, r: 4 }}
                                        activeDot={{ r: 6, fill: '#f59e0b' }}
                                    />
                                </LineChart>
                            </ResponsiveContainer>
                        </CardContent>
                    </Card>
                </div>

                {/* Main Content Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Recent Users */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader className="flex flex-row items-center justify-between">
                            <div>
                                <CardTitle className="text-lg text-gray-900">Recent Users</CardTitle>
                                <CardDescription className="text-gray-500">Latest registrations</CardDescription>
                            </div>
                            <Link href={route('admin.users.index')} className="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1">
                                View all <ArrowRight className="h-4 w-4" />
                            </Link>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentUsers.slice(0, 5).map((user) => (
                                    <div key={user.id} className="flex items-center gap-3">
                                        {user.avatar ? (
                                            <img src={user.avatar} alt={user.name} className="h-10 w-10 rounded-full object-cover" />
                                        ) : (
                                            <div className="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-medium">
                                                {user.name.charAt(0).toUpperCase()}
                                            </div>
                                        )}
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-medium text-gray-900 truncate">{user.name}</p>
                                            <p className="text-xs text-gray-500 truncate">{user.email}</p>
                                        </div>
                                        <div className="flex flex-col items-end gap-1">
                                            {user.roles.map((role) => (
                                                <Badge key={role} variant="secondary" className="text-xs capitalize">
                                                    {role}
                                                </Badge>
                                            ))}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Recent Enrollments */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader className="flex flex-row items-center justify-between">
                            <div>
                                <CardTitle className="text-lg text-gray-900">Recent Enrollments</CardTitle>
                                <CardDescription className="text-gray-500">Latest course enrollments</CardDescription>
                            </div>
                            <Link href={route('admin.enrollments.index')} className="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1">
                                View all <ArrowRight className="h-4 w-4" />
                            </Link>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentEnrollments.slice(0, 5).map((enrollment) => (
                                    <div key={enrollment.id} className="flex items-center gap-3">
                                        {enrollment.user.avatar ? (
                                            <img src={enrollment.user.avatar} alt={enrollment.user.name} className="h-10 w-10 rounded-full object-cover" />
                                        ) : (
                                            <div className="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-medium">
                                                {enrollment.user.name.charAt(0).toUpperCase()}
                                            </div>
                                        )}
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-medium text-gray-900 truncate">{enrollment.user.name}</p>
                                            <p className="text-xs text-gray-500 truncate">{enrollment.course.title}</p>
                                        </div>
                                        <div className="text-right">
                                            <p className="text-sm font-medium text-green-600">{enrollment.progress}%</p>
                                            <p className="text-xs text-gray-400">{enrollment.enrolled_at}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Recent Payments */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader className="flex flex-row items-center justify-between">
                            <div>
                                <CardTitle className="text-lg text-gray-900">Recent Payments</CardTitle>
                                <CardDescription className="text-gray-500">Latest transactions</CardDescription>
                            </div>
                            <Link href={route('admin.payments.index')} className="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1">
                                View all <ArrowRight className="h-4 w-4" />
                            </Link>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {recentPayments.slice(0, 5).map((payment) => (
                                    <div key={payment.id} className="flex items-center gap-3">
                                        <div className="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-medium">
                                            {payment.user?.name?.charAt(0)?.toUpperCase() || '?'}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-medium text-gray-900 truncate">{payment.user?.name || 'Unknown'}</p>
                                            <p className="text-xs text-gray-500">{payment.created_at}</p>
                                        </div>
                                        <div className="text-right">
                                            <p className="text-sm font-bold text-gray-900">{formatCurrency(payment.amount)}</p>
                                            <Badge variant={payment.status === 'completed' ? 'default' : 'secondary'} className="text-xs">
                                                {payment.status}
                                            </Badge>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Bottom Grid */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Top Courses */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader className="flex flex-row items-center justify-between">
                            <div>
                                <CardTitle className="text-lg text-gray-900">Top Courses</CardTitle>
                                <CardDescription className="text-gray-500">By enrollment count</CardDescription>
                            </div>
                            <Link href={route('admin.courses.index')} className="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1">
                                View all <ArrowRight className="h-4 w-4" />
                            </Link>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {topCourses.map((course, index) => (
                                    <div key={course.id} className="flex items-center gap-4">
                                        <div className="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">
                                            {index + 1}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-medium text-gray-900 truncate">{course.title}</p>
                                            <div className="flex items-center gap-2 mt-1">
                                                <span className="text-xs text-gray-500">{course.enrollments_count} students</span>
                                                <span className="text-xs text-gray-300">|</span>
                                                <span className="text-xs text-amber-600 flex items-center gap-1">
                                                    <Star className="h-3 w-3 fill-current" /> {course.average_rating}
                                                </span>
                                            </div>
                                        </div>
                                        <Badge variant={course.is_published ? 'default' : 'secondary'}>
                                            {course.is_published ? 'Published' : 'Draft'}
                                        </Badge>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Top Teachers */}
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader className="flex flex-row items-center justify-between">
                            <div>
                                <CardTitle className="text-lg text-gray-900">Top Teachers</CardTitle>
                                <CardDescription className="text-gray-500">By total enrollments</CardDescription>
                            </div>
                            <Link href={route('admin.users.index')} className="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1">
                                View all <ArrowRight className="h-4 w-4" />
                            </Link>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {topTeachers.map((teacher, index) => (
                                    <div key={teacher.id} className="flex items-center gap-4">
                                        <div className="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-sm">
                                            {index + 1}
                                        </div>
                                        {teacher.avatar ? (
                                            <img src={teacher.avatar} alt={teacher.name} className="h-10 w-10 rounded-full object-cover" />
                                        ) : (
                                            <div className="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-medium">
                                                {teacher.name.charAt(0).toUpperCase()}
                                            </div>
                                        )}
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-medium text-gray-900 truncate">{teacher.name}</p>
                                            <p className="text-xs text-gray-500">{teacher.courses_count} courses</p>
                                        </div>
                                        <div className="text-right">
                                            <p className="text-sm font-bold text-gray-900">{teacher.total_enrollments}</p>
                                            <p className="text-xs text-gray-500">students</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Pending Reviews */}
                {pendingReviews.length > 0 && (
                    <Card className="border-0 shadow-sm bg-white border-l-4 border-l-amber-500">
                        <CardHeader className="flex flex-row items-center justify-between">
                            <div>
                                <CardTitle className="text-lg text-gray-900">Pending Reviews</CardTitle>
                                <CardDescription className="text-gray-500">Reviews awaiting moderation</CardDescription>
                            </div>
                            <Link href={route('admin.reviews.index')} className="text-sm text-amber-600 hover:text-amber-700 flex items-center gap-1">
                                Manage reviews <ArrowRight className="h-4 w-4" />
                            </Link>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {pendingReviews.map((review) => (
                                    <div key={review.id} className="flex items-start gap-4 p-4 bg-amber-50 rounded-lg">
                                        <div className="flex-shrink-0">
                                            <div className="flex items-center gap-1 text-amber-600">
                                                {[...Array(5)].map((_, i) => (
                                                    <Star key={i} className={`h-4 w-4 ${i < review.rating ? 'fill-current' : ''}`} />
                                                ))}
                                            </div>
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-medium text-gray-900">{review.user}</p>
                                            <p className="text-xs text-gray-500 mb-2">on {review.course}</p>
                                            <p className="text-sm text-gray-700 line-clamp-2">{review.comment}</p>
                                        </div>
                                        <p className="text-xs text-gray-400">{review.created_at}</p>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                )}
            </div>
        </AdminLayout>
    );
}
