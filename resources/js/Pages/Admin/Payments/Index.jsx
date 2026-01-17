import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Badge } from '../../../components/ui/badge';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '../../../components/ui/select';
import {
    Table, TableBody, TableCell, TableHead, TableHeader, TableRow,
} from '../../../components/ui/table';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '../../../components/ui/dialog';
import {
    CreditCard, Search, DollarSign, Clock, CheckCircle, XCircle,
    ChevronLeft, ChevronRight, Download, Eye, Filter, RefreshCw,
    Smartphone, Wallet, ArrowUpRight, ArrowDownRight
} from 'lucide-react';

export default function Index({ payments, stats, filters }) {
    const [search, setSearch] = useState(filters.search || '');
    const [statusFilter, setStatusFilter] = useState(filters.status || 'all');
    const [selectedPayment, setSelectedPayment] = useState(null);
    const [isRefreshing, setIsRefreshing] = useState(false);

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('admin.payments.index'), {
            search,
            status: statusFilter === 'all' ? '' : statusFilter
        }, { preserveState: true });
    };

    const handleStatusFilter = (status) => {
        setStatusFilter(status);
        router.get(route('admin.payments.index'), {
            search,
            status: status === 'all' ? '' : status
        }, { preserveState: true });
    };

    const handleRefresh = () => {
        setIsRefreshing(true);
        router.reload({
            onFinish: () => setIsRefreshing(false)
        });
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-KE', {
            style: 'currency',
            currency: 'KES',
            minimumFractionDigits: 0,
        }).format(amount);
    };

    const getStatusBadge = (status) => {
        const config = {
            completed: {
                className: 'bg-emerald-100 text-emerald-700 border-emerald-200',
                icon: CheckCircle,
                label: 'Completed'
            },
            pending: {
                className: 'bg-amber-100 text-amber-700 border-amber-200',
                icon: Clock,
                label: 'Pending'
            },
            failed: {
                className: 'bg-red-100 text-red-700 border-red-200',
                icon: XCircle,
                label: 'Failed'
            },
        };
        const { className, icon: Icon, label } = config[status] || { className: 'bg-gray-100', label: status };
        return (
            <Badge className={`${className} border gap-1.5 font-medium`}>
                {Icon && <Icon className="h-3 w-3" />}
                {label}
            </Badge>
        );
    };

    const getPaymentMethodIcon = (method) => {
        if (method === 'mpesa') return <Smartphone className="h-4 w-4 text-green-600" />;
        if (method === 'card') return <CreditCard className="h-4 w-4 text-blue-600" />;
        return <Wallet className="h-4 w-4 text-gray-600" />;
    };

    const statCards = [
        {
            title: 'Total Revenue',
            value: formatCurrency(stats.total_revenue),
            icon: DollarSign,
            color: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-100',
            description: 'From completed payments'
        },
        {
            title: 'Completed',
            value: stats.completed.toLocaleString(),
            icon: CheckCircle,
            color: 'text-emerald-600',
            bgColor: 'bg-emerald-50',
            borderColor: 'border-emerald-100',
            description: 'Successful transactions'
        },
        {
            title: 'Pending',
            value: stats.pending.toLocaleString(),
            icon: Clock,
            color: 'text-amber-600',
            bgColor: 'bg-amber-50',
            borderColor: 'border-amber-100',
            description: 'Awaiting confirmation'
        },
        {
            title: 'Failed',
            value: stats.failed.toLocaleString(),
            icon: XCircle,
            color: 'text-red-600',
            bgColor: 'bg-red-50',
            borderColor: 'border-red-100',
            description: 'Unsuccessful attempts'
        },
    ];

    const successRate = stats.total > 0
        ? Math.round((stats.completed / stats.total) * 100)
        : 0;

    return (
        <AdminLayout>
            <Head title="Payments" />

            <div className="space-y-6">
                {/* Page Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">Payments</h1>
                        <p className="mt-1 text-gray-500">Track and manage all platform transactions</p>
                    </div>
                    <div className="flex items-center gap-2">
                        <Button
                            variant="outline"
                            size="sm"
                            onClick={handleRefresh}
                            disabled={isRefreshing}
                        >
                            <RefreshCw className={`h-4 w-4 mr-2 ${isRefreshing ? 'animate-spin' : ''}`} />
                            Refresh
                        </Button>
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
                                        <p className="text-2xl font-bold text-gray-900 mt-1">{stat.value}</p>
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

                {/* Success Rate Card */}
                <Card className="border-0 shadow-sm bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
                    <CardContent className="p-5">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-emerald-100 text-sm font-medium">Payment Success Rate</p>
                                <p className="text-3xl font-bold mt-1">{successRate}%</p>
                                <p className="text-emerald-100 text-sm mt-1">
                                    {stats.completed} of {stats.total} transactions successful
                                </p>
                            </div>
                            <div className="h-20 w-20 rounded-full bg-white/20 flex items-center justify-center">
                                <div className="h-16 w-16 rounded-full bg-white/30 flex items-center justify-center">
                                    <CheckCircle className="h-8 w-8 text-white" />
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Filters */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-4">
                        <div className="flex flex-col md:flex-row gap-4">
                            <form onSubmit={handleSearch} className="flex-1 flex gap-2">
                                <div className="relative flex-1">
                                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                    <Input
                                        type="text"
                                        placeholder="Search by reference, user name or email..."
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        className="pl-10"
                                    />
                                </div>
                                <Button type="submit">Search</Button>
                            </form>

                            <div className="flex items-center gap-3">
                                <div className="flex items-center gap-2">
                                    <Filter className="h-4 w-4 text-gray-400" />
                                    <Select value={statusFilter} onValueChange={handleStatusFilter}>
                                        <SelectTrigger className="w-[150px]">
                                            <SelectValue placeholder="Status" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">All Status</SelectItem>
                                            <SelectItem value="completed">Completed</SelectItem>
                                            <SelectItem value="pending">Pending</SelectItem>
                                            <SelectItem value="failed">Failed</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Payments Table */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardHeader className="pb-0">
                        <CardTitle className="text-lg">Recent Transactions</CardTitle>
                        <CardDescription>A list of all payment transactions on the platform</CardDescription>
                    </CardHeader>
                    <CardContent className="p-0 pt-4">
                        <Table>
                            <TableHeader>
                                <TableRow className="bg-gray-50/50">
                                    <TableHead className="font-semibold">Reference</TableHead>
                                    <TableHead className="font-semibold">User</TableHead>
                                    <TableHead className="font-semibold">Amount</TableHead>
                                    <TableHead className="font-semibold">Method</TableHead>
                                    <TableHead className="font-semibold">Status</TableHead>
                                    <TableHead className="font-semibold">Date</TableHead>
                                    <TableHead className="text-right font-semibold">Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {payments.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={7} className="h-32 text-center">
                                            <div className="flex flex-col items-center justify-center text-gray-500">
                                                <CreditCard className="h-10 w-10 mb-2 opacity-30" />
                                                <p className="font-medium">No payments found</p>
                                                <p className="text-sm">Try adjusting your search or filters</p>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    payments.data.map((payment) => (
                                        <TableRow key={payment.id} className="hover:bg-gray-50/50">
                                            <TableCell>
                                                <code className="text-xs bg-gray-100 px-2 py-1 rounded font-mono">
                                                    {payment.reference?.substring(0, 16)}...
                                                </code>
                                            </TableCell>
                                            <TableCell>
                                                {payment.user ? (
                                                    <div className="flex items-center gap-3">
                                                        {payment.user.avatar ? (
                                                            <img
                                                                src={payment.user.avatar}
                                                                alt={payment.user.name}
                                                                className="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm"
                                                            />
                                                        ) : (
                                                            <div className="h-9 w-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                                                {payment.user.name.charAt(0)}
                                                            </div>
                                                        )}
                                                        <div>
                                                            <p className="font-medium text-gray-900 text-sm">{payment.user.name}</p>
                                                            <p className="text-xs text-gray-500">{payment.user.email}</p>
                                                        </div>
                                                    </div>
                                                ) : (
                                                    <span className="text-gray-400 text-sm">Unknown User</span>
                                                )}
                                            </TableCell>
                                            <TableCell>
                                                <span className="font-bold text-gray-900">
                                                    {formatCurrency(payment.amount)}
                                                </span>
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2">
                                                    {getPaymentMethodIcon(payment.payment_method)}
                                                    <span className="capitalize text-sm text-gray-600">
                                                        {payment.payment_method || 'N/A'}
                                                    </span>
                                                </div>
                                            </TableCell>
                                            <TableCell>{getStatusBadge(payment.status)}</TableCell>
                                            <TableCell>
                                                <span className="text-gray-500 text-sm">{payment.created_at}</span>
                                            </TableCell>
                                            <TableCell className="text-right">
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    onClick={() => setSelectedPayment(payment)}
                                                >
                                                    <Eye className="h-4 w-4" />
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                )}
                            </TableBody>
                        </Table>

                        {/* Pagination */}
                        {payments.last_page > 1 && (
                            <div className="flex items-center justify-between px-4 py-4 border-t">
                                <p className="text-sm text-gray-500">
                                    Showing <span className="font-medium">{payments.from}</span> to{' '}
                                    <span className="font-medium">{payments.to}</span> of{' '}
                                    <span className="font-medium">{payments.total}</span> results
                                </p>
                                <div className="flex gap-2">
                                    {payments.prev_page_url && (
                                        <Link href={payments.prev_page_url} preserveState>
                                            <Button variant="outline" size="sm">
                                                <ChevronLeft className="h-4 w-4 mr-1" />
                                                Previous
                                            </Button>
                                        </Link>
                                    )}
                                    {payments.next_page_url && (
                                        <Link href={payments.next_page_url} preserveState>
                                            <Button variant="outline" size="sm">
                                                Next
                                                <ChevronRight className="h-4 w-4 ml-1" />
                                            </Button>
                                        </Link>
                                    )}
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>

            {/* Payment Details Dialog */}
            <Dialog open={!!selectedPayment} onOpenChange={() => setSelectedPayment(null)}>
                <DialogContent className="sm:max-w-md">
                    <DialogHeader>
                        <DialogTitle>Payment Details</DialogTitle>
                        <DialogDescription>
                            Transaction information and status
                        </DialogDescription>
                    </DialogHeader>
                    {selectedPayment && (
                        <div className="space-y-4">
                            <div className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p className="text-sm text-gray-500">Amount</p>
                                    <p className="text-2xl font-bold text-gray-900">
                                        {formatCurrency(selectedPayment.amount)}
                                    </p>
                                </div>
                                {getStatusBadge(selectedPayment.status)}
                            </div>

                            <div className="space-y-3">
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-500 text-sm">Reference</span>
                                    <code className="text-xs bg-gray-100 px-2 py-1 rounded font-mono">
                                        {selectedPayment.reference}
                                    </code>
                                </div>
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-500 text-sm">Customer</span>
                                    <span className="font-medium text-sm">{selectedPayment.user?.name || 'Unknown'}</span>
                                </div>
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-500 text-sm">Email</span>
                                    <span className="text-sm">{selectedPayment.user?.email || 'N/A'}</span>
                                </div>
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-500 text-sm">Payment Method</span>
                                    <div className="flex items-center gap-2">
                                        {getPaymentMethodIcon(selectedPayment.payment_method)}
                                        <span className="capitalize text-sm">{selectedPayment.payment_method}</span>
                                    </div>
                                </div>
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-500 text-sm">Currency</span>
                                    <span className="text-sm">{selectedPayment.currency}</span>
                                </div>
                                <div className="flex justify-between py-2">
                                    <span className="text-gray-500 text-sm">Date</span>
                                    <span className="text-sm">{selectedPayment.created_at}</span>
                                </div>
                            </div>
                        </div>
                    )}
                </DialogContent>
            </Dialog>
        </AdminLayout>
    );
}
