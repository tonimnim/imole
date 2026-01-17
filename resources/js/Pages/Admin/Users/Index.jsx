import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Badge } from '../../../components/ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '../../../components/ui/table';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '../../../components/ui/alert-dialog';
import {
    Users,
    UserPlus,
    Search,
    Edit,
    Trash2,
    Shield,
    GraduationCap,
    BookOpen,
    ChevronLeft,
    ChevronRight
} from 'lucide-react';

export default function Index({ users, roles, stats, filters }) {
    const [search, setSearch] = useState(filters.search || '');
    const [roleFilter, setRoleFilter] = useState(filters.role || '');
    const [deleteUser, setDeleteUser] = useState(null);

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(route('admin.users.index'), { search, role: roleFilter }, { preserveState: true });
    };

    const handleRoleFilter = (role) => {
        setRoleFilter(role);
        router.get(route('admin.users.index'), { search, role }, { preserveState: true });
    };

    const handleDelete = () => {
        if (deleteUser) {
            router.delete(route('admin.users.destroy', deleteUser.id), {
                onSuccess: () => setDeleteUser(null),
            });
        }
    };

    const getRoleBadgeColor = (role) => {
        switch (role) {
            case 'admin': return 'bg-red-100 text-red-700';
            case 'teacher': return 'bg-green-100 text-green-700';
            case 'student': return 'bg-blue-100 text-blue-700';
            default: return 'bg-gray-100 text-gray-700';
        }
    };

    const statCards = [
        { title: 'Total Users', value: stats.total, icon: Users, color: 'text-blue-600', bgColor: 'bg-blue-50' },
        { title: 'Admins', value: stats.admins, icon: Shield, color: 'text-red-600', bgColor: 'bg-red-50' },
        { title: 'Teachers', value: stats.teachers, icon: BookOpen, color: 'text-green-600', bgColor: 'bg-green-50' },
        { title: 'Students', value: stats.students, icon: GraduationCap, color: 'text-purple-600', bgColor: 'bg-purple-50' },
    ];

    return (
        <AdminLayout>
            <Head title="Users Management" />

            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">Users</h1>
                        <p className="mt-1 text-gray-500">Manage all platform users</p>
                    </div>
                    <Link href={route('admin.users.create')}>
                        <Button className="bg-amber-500 hover:bg-amber-600">
                            <UserPlus className="h-4 w-4 mr-2" />
                            Add User
                        </Button>
                    </Link>
                </div>

                {/* Stats */}
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

                {/* Filters */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-4">
                        <div className="flex flex-col md:flex-row gap-4">
                            <form onSubmit={handleSearch} className="flex-1 flex gap-2">
                                <div className="relative flex-1">
                                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                    <Input
                                        type="text"
                                        placeholder="Search users..."
                                        value={search}
                                        onChange={(e) => setSearch(e.target.value)}
                                        className="pl-10"
                                    />
                                </div>
                                <Button type="submit" variant="outline">Search</Button>
                            </form>
                            <div className="flex gap-2">
                                <Button
                                    variant={roleFilter === '' ? 'default' : 'outline'}
                                    onClick={() => handleRoleFilter('')}
                                    size="sm"
                                >
                                    All
                                </Button>
                                {roles.map((role) => (
                                    <Button
                                        key={role}
                                        variant={roleFilter === role ? 'default' : 'outline'}
                                        onClick={() => handleRoleFilter(role)}
                                        size="sm"
                                        className="capitalize"
                                    >
                                        {role}
                                    </Button>
                                ))}
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Users Table */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>User</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead>Role</TableHead>
                                    <TableHead>Verified</TableHead>
                                    <TableHead>Joined</TableHead>
                                    <TableHead className="text-right">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {users.data.map((user) => (
                                    <TableRow key={user.id}>
                                        <TableCell>
                                            <div className="flex items-center gap-3">
                                                {user.avatar ? (
                                                    <img src={user.avatar} alt={user.name} className="h-10 w-10 rounded-full object-cover" />
                                                ) : (
                                                    <div className="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-medium">
                                                        {user.name.charAt(0).toUpperCase()}
                                                    </div>
                                                )}
                                                <span className="font-medium text-gray-900">{user.name}</span>
                                            </div>
                                        </TableCell>
                                        <TableCell className="text-gray-500">{user.email}</TableCell>
                                        <TableCell>
                                            {user.roles.map((role) => (
                                                <Badge key={role} className={`${getRoleBadgeColor(role)} capitalize`}>
                                                    {role}
                                                </Badge>
                                            ))}
                                        </TableCell>
                                        <TableCell>
                                            {user.email_verified_at ? (
                                                <Badge variant="outline" className="text-green-600 border-green-200">Verified</Badge>
                                            ) : (
                                                <Badge variant="outline" className="text-gray-400">Pending</Badge>
                                            )}
                                        </TableCell>
                                        <TableCell className="text-gray-500">{user.created_at}</TableCell>
                                        <TableCell className="text-right">
                                            <div className="flex items-center justify-end gap-2">
                                                <Link href={route('admin.users.edit', user.id)}>
                                                    <Button variant="ghost" size="sm">
                                                        <Edit className="h-4 w-4" />
                                                    </Button>
                                                </Link>
                                                <Button
                                                    variant="ghost"
                                                    size="sm"
                                                    className="text-red-600 hover:text-red-700 hover:bg-red-50"
                                                    onClick={() => setDeleteUser(user)}
                                                >
                                                    <Trash2 className="h-4 w-4" />
                                                </Button>
                                            </div>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>

                        {/* Pagination */}
                        {users.last_page > 1 && (
                            <div className="flex items-center justify-between px-4 py-3 border-t">
                                <p className="text-sm text-gray-500">
                                    Showing {users.from} to {users.to} of {users.total} users
                                </p>
                                <div className="flex gap-2">
                                    {users.prev_page_url && (
                                        <Link href={users.prev_page_url}>
                                            <Button variant="outline" size="sm">
                                                <ChevronLeft className="h-4 w-4 mr-1" /> Previous
                                            </Button>
                                        </Link>
                                    )}
                                    {users.next_page_url && (
                                        <Link href={users.next_page_url}>
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

            {/* Delete Confirmation Dialog */}
            <AlertDialog open={!!deleteUser} onOpenChange={() => setDeleteUser(null)}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Delete User</AlertDialogTitle>
                        <AlertDialogDescription>
                            Are you sure you want to delete {deleteUser?.name}? This action cannot be undone.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction onClick={handleDelete} className="bg-red-600 hover:bg-red-700">
                            Delete
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </AdminLayout>
    );
}
