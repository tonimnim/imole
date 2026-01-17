import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { cn } from '../lib/utils';
import {
    LayoutDashboard,
    Users,
    BookOpen,
    FolderTree,
    CreditCard,
    GraduationCap,
    Settings,
    Menu,
    X,
    LogOut,
    BarChart3,
    Bell,
    TrendingUp
} from 'lucide-react';

export default function AdminLayout({ children }) {
    const { auth } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);

    const navigation = [
        { name: 'Dashboard', href: route('admin.dashboard'), icon: LayoutDashboard, current: route().current('admin.dashboard') },

        { group: 'User Management' },
        { name: 'Users', href: route('admin.users.index'), icon: Users, current: route().current('admin.users*') },

        { group: 'Course Management' },
        { name: 'Courses', href: route('admin.courses.index'), icon: BookOpen, current: route().current('admin.courses*') },
        { name: 'Categories', href: route('admin.categories.index'), icon: FolderTree, current: route().current('admin.categories*') },

        { group: 'Financial' },
        { name: 'Payments', href: route('admin.payments.index'), icon: CreditCard, current: route().current('admin.payments*') },
        { name: 'Revenue', href: route('admin.revenue.index'), icon: TrendingUp, current: route().current('admin.revenue*') },

        { group: 'Engagement' },
        { name: 'Enrollments', href: route('admin.enrollments.index'), icon: GraduationCap, current: route().current('admin.enrollments*') },

        { group: 'System' },
        { name: 'Announcements', href: route('admin.announcements.index'), icon: Bell, current: route().current('admin.announcements*') },
        { name: 'Reports', href: route('admin.reports.index'), icon: BarChart3, current: route().current('admin.reports*') },
        { name: 'Settings', href: route('admin.settings.index'), icon: Settings, current: route().current('admin.settings*') },
    ];

    return (
        <div className="min-h-screen bg-gray-50 flex">
            {/* Mobile Sidebar Overlay */}
            <div
                className={cn(
                    "fixed inset-0 bg-gray-900/50 z-40 lg:hidden transition-opacity",
                    sidebarOpen ? "opacity-100" : "opacity-0 pointer-events-none"
                )}
                onClick={() => setSidebarOpen(false)}
            />

            {/* Sidebar */}
            <aside
                className={cn(
                    "fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 transform transition-transform duration-200 ease-in-out flex flex-col h-screen",
                    sidebarOpen ? "translate-x-0" : "-translate-x-full lg:translate-x-0"
                )}
            >
                {/* Logo */}
                <div className="h-16 flex items-center px-6 border-b border-slate-700">
                    <span className="text-2xl font-bold text-white tracking-tight">
                        Imole<span className="text-amber-500">.</span>
                    </span>
                    <span className="ml-2 px-2 py-0.5 text-xs font-medium bg-amber-500 text-slate-900 rounded">
                        Admin
                    </span>
                    <button
                        className="ml-auto lg:hidden text-slate-400"
                        onClick={() => setSidebarOpen(false)}
                    >
                        <X size={24} />
                    </button>
                </div>

                {/* Navigation Links */}
                <nav className="flex-1 p-4 space-y-1 overflow-hidden">
                    {navigation.map((item, index) => (
                        item.group ? (
                            <div key={index} className="mt-6 mb-2 px-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                {item.group}
                            </div>
                        ) : (
                            <Link
                                key={item.name}
                                href={item.href}
                                className={cn(
                                    "flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors",
                                    item.current
                                        ? "bg-amber-500/10 text-amber-500"
                                        : "text-slate-300 hover:bg-slate-800 hover:text-white"
                                )}
                            >
                                <item.icon className={cn("mr-3 h-5 w-5", item.current ? "text-amber-500" : "text-slate-400")} />
                                {item.name}
                            </Link>
                        )
                    ))}
                </nav>

                {/* User Profile / Logout */}
                <div className="border-t border-slate-700 p-4">
                    <div className="flex items-center mb-4 px-2">
                        {auth.user.avatar_url ? (
                            <img
                                src={auth.user.avatar_url}
                                alt={auth.user.name}
                                className="h-10 w-10 rounded-full object-cover border-2 border-amber-500"
                            />
                        ) : (
                            <div className="h-10 w-10 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-slate-900 font-bold">
                                {auth.user.name.charAt(0).toUpperCase()}
                            </div>
                        )}
                        <div className="ml-3">
                            <p className="text-sm font-medium text-white">{auth.user.name}</p>
                            <p className="text-xs text-slate-400 truncate w-32">Administrator</p>
                        </div>
                    </div>
                    <Link
                        href={route('logout')}
                        method="post"
                        as="button"
                        className="w-full flex items-center px-3 py-2 text-sm font-medium text-red-400 rounded-md hover:bg-red-500/10 transition-colors"
                    >
                        <LogOut className="mr-3 h-5 w-5" />
                        Sign Out
                    </Link>
                </div>
            </aside>

            {/* Main Content Area */}
            <div className="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
                {/* Mobile Header */}
                <header className="lg:hidden h-16 bg-slate-900 border-b border-slate-700 flex items-center px-4 justify-between">
                    <button
                        className="text-slate-400 focus:outline-none"
                        onClick={() => setSidebarOpen(true)}
                    >
                        <Menu size={24} />
                    </button>
                    <span className="text-xl font-bold text-white">Imole Admin</span>
                    <div className="w-6" />
                </header>

                {/* Page Content */}
                <main className="flex-1 overflow-y-auto p-4 lg:p-8">
                    {children}
                </main>
            </div>
        </div>
    );
}
