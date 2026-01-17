import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Badge } from '../../../components/ui/badge';
import {
    Table, TableBody, TableCell, TableHead, TableHeader, TableRow,
} from '../../../components/ui/table';
import {
    CreditCard, Search, DollarSign, Clock, CheckCircle, XCircle, ChevronLeft, ChevronRight
} from 'lucide-react';

export default function Index({ payments, stats, filters }) {
    const [search, setSearch] = useState(filters.search || '');
    const [statusFilter, setStatusFilter] = useState(filters.status || '');

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('admin.payments.index'), { search, status: statusFilter }, { preserveState: true });
    };

    const handleStatusFilter = (status) => {
        setStatusFilter(status);
        router.get(route('admin.payments.index'), { search, status }, { preserveState: true });
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('en-KE', {
            style: 'currency', currency: 'KES', minimumFractionDigits: 0,
        }).format(amount);
    };

    const getStatusBadge = (status) => {
        const styles = {
            completed: 'bg-green-100 text-green-700',
            pending: 'bg-yellow-100 text-yellow-700',
            failed: 'bg-red-100 text-red-700',
        };
        return <Badge className={styles[status] || 'bg-gray-100'}>{status}</Badge>;
    };

    const statCards = [
        { title: 'Total Revenue', value: formatCurrency(stats.total_revenue), icon: DollarSign, color: 'text-green-600', bgColor: 'bg-green-50' },
        { title: 'Completed', value: stats.completed, icon: CheckCircle, color: 'text-green-600', bgColor: 'bg-green-50' },
        { title: 'Pending', value: stats.pending, icon: Clock, color: 'text-yellow-600', bgColor: 'bg-yellow-50' },
        { title: 'Failed', value: stats.failed, icon: XCircle, color: 'text-red-600', bgColor: 'bg-red-50' },
    ];

    return (
        <AdminLayout>
            <Head title="Payments" />

            <div className="space-y-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Payments</h1>
                    <p className="mt-1 text-gray-500">Track all platform transactions</p>
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
                                        <p className="text-sm text-gray-500">{stat.title}</p>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    ))}
                </div>

                <Card className="border-0 shadow-sm bg-white">
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
                                <Button type="submit" variant="outline">Search</Button>
                            </form>
                            <div className="flex gap-2">
                                {['', 'completed', 'pending', 'failed'].map((status) => (
                                    <Button
                                        key={status}
                                        variant={statusFilter === status ? 'default' : 'outline'}
                                        onClick={() => handleStatusFilter(status)}
                                        size="sm"
                                        className="capitalize"
                                    >
                                        {status || 'All'}
                                    </Button>
                                ))}
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Reference</TableHead>
                                    <TableHead>User</TableHead>
                                    <TableHead>Amount</TableHead>
                                    <TableHead>Method</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Date</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {payments.data.map((payment) => (
                                    <TableRow key={payment.id}>
                                        <TableCell className="font-mono text-sm">{payment.reference}</TableCell>
                                        <TableCell>
                                            {payment.user ? (
                                                <div className="flex items-center gap-2">
                                                    {payment.user.avatar ? (
                                                        <img src={payment.user.avatar} className="h-8 w-8 rounded-full" />
                                                    ) : (
                                                        <div className="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center text-amber-700 text-xs font-medium">
                                                            {payment.user.name.charAt(0)}
                                                        </div>
                                                    )}
                                                    <span className="text-sm">{payment.user.name}</span>
                                                </div>
                                            ) : 'Unknown'}
                                        </TableCell>
                                        <TableCell className="font-bold">{formatCurrency(payment.amount)}</TableCell>
                                        <TableCell className="capitalize">{payment.payment_method || '-'}</TableCell>
                                        <TableCell>{getStatusBadge(payment.status)}</TableCell>
                                        <TableCell className="text-gray-500">{payment.created_at}</TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>

                        {payments.last_page > 1 && (
                            <div className="flex items-center justify-between px-4 py-3 border-t">
                                <p className="text-sm text-gray-500">
                                    Showing {payments.from} to {payments.to} of {payments.total}
                                </p>
                                <div className="flex gap-2">
                                    {payments.prev_page_url && (
                                        <Link href={payments.prev_page_url}>
                                            <Button variant="outline" size="sm"><ChevronLeft className="h-4 w-4" /></Button>
                                        </Link>
                                    )}
                                    {payments.next_page_url && (
                                        <Link href={payments.next_page_url}>
                                            <Button variant="outline" size="sm"><ChevronRight className="h-4 w-4" /></Button>
                                        </Link>
                                    )}
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </AdminLayout>
    );
}
