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
    ChevronLeft, ChevronRight, Download, Eye, RefreshCw, Smartphone
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
        router.reload({ onFinish: () => setIsRefreshing(false) });
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-KE', {
            style: 'currency',
            currency: 'KES',
            minimumFractionDigits: 0,
        }).format(amount || 0);
    };

    const getStatusBadge = (status) => {
        const config = {
            completed: { className: 'bg-green-100 text-green-700', label: 'Completed' },
            success: { className: 'bg-green-100 text-green-700', label: 'Success' },
            pending: { className: 'bg-yellow-100 text-yellow-700', label: 'Pending' },
            failed: { className: 'bg-red-100 text-red-700', label: 'Failed' },
        };
        const { className, label } = config[status] || { className: 'bg-gray-100 text-gray-700', label: status };
        return <Badge className={className}>{label}</Badge>;
    };

    const getPaymentMethodIcon = (method) => {
        if (method === 'mpesa') return <Smartphone className="h-4 w-4 text-green-600" />;
        return <CreditCard className="h-4 w-4 text-blue-600" />;
    };

    return (
        <AdminLayout>
            <Head title="Payments" />

            <div className="space-y-6">
                {/* Page Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Payments</h1>
                        <p className="text-gray-600">Track and manage all platform transactions</p>
                    </div>
                    <div className="flex items-center gap-2">
                        <Button variant="outline" size="sm" onClick={handleRefresh} disabled={isRefreshing}>
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
                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600">Total Revenue</p>
                                    <p className="text-2xl font-bold text-gray-900 mt-1">
                                        {formatCurrency(stats.total_revenue)}
                                    </p>
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
                                    <p className="text-sm text-gray-600">Completed</p>
                                    <p className="text-2xl font-bold text-gray-900 mt-1">
                                        {stats.completed?.toLocaleString() || 0}
                                    </p>
                                </div>
                                <div className="p-3 bg-green-50 rounded-lg">
                                    <CheckCircle className="h-5 w-5 text-green-600" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600">Pending</p>
                                    <p className="text-2xl font-bold text-gray-900 mt-1">
                                        {stats.pending?.toLocaleString() || 0}
                                    </p>
                                </div>
                                <div className="p-3 bg-yellow-50 rounded-lg">
                                    <Clock className="h-5 w-5 text-yellow-600" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="bg-white border border-gray-200">
                        <CardContent className="p-5">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm text-gray-600">Failed</p>
                                    <p className="text-2xl font-bold text-gray-900 mt-1">
                                        {stats.failed?.toLocaleString() || 0}
                                    </p>
                                </div>
                                <div className="p-3 bg-red-50 rounded-lg">
                                    <XCircle className="h-5 w-5 text-red-600" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Filters */}
                <Card className="bg-white border border-gray-200">
                    <CardContent className="p-4">
                        <div className="flex flex-col md:flex-row gap-4">
                            <form onSubmit={handleSearch} className="flex-1 flex gap-2">
                                <div className="relative flex-1">
                                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                    <Input
                                        type="text"
                                        placeholder="Search by reference or user..."
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        className="pl-10"
                                    />
                                </div>
                                <Button type="submit">Search</Button>
                            </form>

                            <Select value={statusFilter} onValueChange={handleStatusFilter}>
                                <SelectTrigger className="w-[150px] bg-white">
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
                    </CardContent>
                </Card>

                {/* Payments Table */}
                <Card className="bg-white border border-gray-200">
                    <CardHeader className="pb-0">
                        <CardTitle className="text-lg text-gray-900">Recent Transactions</CardTitle>
                        <CardDescription className="text-gray-600">
                            A list of all payment transactions
                        </CardDescription>
                    </CardHeader>
                    <CardContent className="p-0 pt-4">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead className="text-gray-700">Reference</TableHead>
                                    <TableHead className="text-gray-700">User</TableHead>
                                    <TableHead className="text-gray-700">Amount</TableHead>
                                    <TableHead className="text-gray-700">Method</TableHead>
                                    <TableHead className="text-gray-700">Status</TableHead>
                                    <TableHead className="text-gray-700">Date</TableHead>
                                    <TableHead className="text-right text-gray-700">Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {payments.data.length === 0 ? (
                                    <TableRow>
                                        <TableCell colSpan={7} className="h-32 text-center">
                                            <div className="flex flex-col items-center justify-center">
                                                <CreditCard className="h-10 w-10 mb-2 text-gray-300" />
                                                <p className="font-medium text-gray-700">No payments found</p>
                                                <p className="text-sm text-gray-500">Try adjusting your filters</p>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                ) : (
                                    payments.data.map((payment) => (
                                        <TableRow key={payment.id}>
                                            <TableCell>
                                                <code className="text-xs bg-gray-100 px-2 py-1 rounded text-gray-700">
                                                    {payment.reference?.substring(0, 16)}...
                                                </code>
                                            </TableCell>
                                            <TableCell>
                                                {payment.user ? (
                                                    <div className="flex items-center gap-2">
                                                        {payment.user.avatar ? (
                                                            <img src={payment.user.avatar} className="h-8 w-8 rounded-full" alt="" />
                                                        ) : (
                                                            <div className="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-medium">
                                                                {payment.user.name.charAt(0)}
                                                            </div>
                                                        )}
                                                        <div>
                                                            <p className="text-sm font-medium text-gray-900">{payment.user.name}</p>
                                                            <p className="text-xs text-gray-500">{payment.user.email}</p>
                                                        </div>
                                                    </div>
                                                ) : (
                                                    <span className="text-gray-500">Unknown</span>
                                                )}
                                            </TableCell>
                                            <TableCell className="font-semibold text-gray-900">
                                                {formatCurrency(payment.amount)}
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex items-center gap-2">
                                                    {getPaymentMethodIcon(payment.payment_method)}
                                                    <span className="capitalize text-sm text-gray-700">
                                                        {payment.payment_method || 'Card'}
                                                    </span>
                                                </div>
                                            </TableCell>
                                            <TableCell>{getStatusBadge(payment.status)}</TableCell>
                                            <TableCell className="text-gray-600 text-sm">{payment.created_at}</TableCell>
                                            <TableCell className="text-right">
                                                <Button variant="ghost" size="sm" onClick={() => setSelectedPayment(payment)}>
                                                    <Eye className="h-4 w-4" />
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    ))
                                )}
                            </TableBody>
                        </Table>

                        {payments.last_page > 1 && (
                            <div className="flex items-center justify-between px-4 py-4 border-t">
                                <p className="text-sm text-gray-600">
                                    Showing {payments.from} to {payments.to} of {payments.total} results
                                </p>
                                <div className="flex gap-2">
                                    {payments.prev_page_url && (
                                        <Link href={payments.prev_page_url} preserveState>
                                            <Button variant="outline" size="sm">
                                                <ChevronLeft className="h-4 w-4 mr-1" /> Previous
                                            </Button>
                                        </Link>
                                    )}
                                    {payments.next_page_url && (
                                        <Link href={payments.next_page_url} preserveState>
                                            <Button variant="outline" size="sm">
                                                Next <ChevronRight className="h-4 w-4 ml-1" />
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
                        <DialogTitle className="text-gray-900">Payment Details</DialogTitle>
                        <DialogDescription className="text-gray-600">
                            Transaction information
                        </DialogDescription>
                    </DialogHeader>
                    {selectedPayment && (
                        <div className="space-y-4">
                            <div className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p className="text-sm text-gray-600">Amount</p>
                                    <p className="text-2xl font-bold text-gray-900">
                                        {formatCurrency(selectedPayment.amount)}
                                    </p>
                                </div>
                                {getStatusBadge(selectedPayment.status)}
                            </div>

                            <div className="space-y-3">
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-600 text-sm">Reference</span>
                                    <code className="text-xs bg-gray-100 px-2 py-1 rounded text-gray-700">
                                        {selectedPayment.reference}
                                    </code>
                                </div>
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-600 text-sm">Customer</span>
                                    <span className="font-medium text-sm text-gray-900">{selectedPayment.user?.name || 'Unknown'}</span>
                                </div>
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-600 text-sm">Email</span>
                                    <span className="text-sm text-gray-700">{selectedPayment.user?.email || 'N/A'}</span>
                                </div>
                                <div className="flex justify-between py-2 border-b">
                                    <span className="text-gray-600 text-sm">Payment Method</span>
                                    <div className="flex items-center gap-2">
                                        {getPaymentMethodIcon(selectedPayment.payment_method)}
                                        <span className="capitalize text-sm text-gray-700">{selectedPayment.payment_method}</span>
                                    </div>
                                </div>
                                <div className="flex justify-between py-2">
                                    <span className="text-gray-600 text-sm">Date</span>
                                    <span className="text-sm text-gray-700">{selectedPayment.created_at}</span>
                                </div>
                            </div>
                        </div>
                    )}
                </DialogContent>
            </Dialog>
        </AdminLayout>
    );
}
