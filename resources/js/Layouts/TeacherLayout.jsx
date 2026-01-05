import React, { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { cn } from '../lib/utils';
import {
    BookOpen,
    Users,
    Megaphone,
    Trophy,
    Layers,
    PlayCircle,
    GraduationCap,
    HelpCircle,
    ClipboardList,
    Star,
    LayoutDashboard,
    Menu,
    X,
    LogOut,
    User
} from 'lucide-react';
import { Button } from '../components/ui/button';

export default function TeacherLayout({ children }) {
    const { auth } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);

    const navigation = [
        { name: 'Dashboard', href: route('teacher.dashboard'), icon: LayoutDashboard, current: route().current('teacher.dashboard') },
        
        { group: 'Course Management' },
        { name: 'Courses', href: route('teacher.courses'), icon: BookOpen, current: route().current('teacher.courses*') },
        { name: 'Modules', href: route('teacher.modules'), icon: Layers, current: route().current('teacher.modules') },
        { name: 'Lessons', href: route('teacher.lessons'), icon: PlayCircle, current: route().current('teacher.lessons') },
        { name: 'Assignments', href: route('teacher.assignments'), icon: ClipboardList, current: route().current('teacher.assignments') },
        { name: 'Quizzes', href: route('teacher.quizzes'), icon: GraduationCap, current: route().current('teacher.quizzes') },
        { name: 'Questions', href: route('teacher.questions'), icon: HelpCircle, current: route().current('teacher.questions') },
        
        { group: 'Student Engagement' },
        { name: 'Students', href: route('teacher.students'), icon: Users, current: route().current('teacher.students') },
        { name: 'Reviews', href: route('teacher.reviews'), icon: Star, current: route().current('teacher.reviews') },

        { group: 'Communication' },
        { name: 'Announcements', href: route('teacher.announcements'), icon: Megaphone, current: route().current('teacher.announcements*') },

        { group: 'Rewards' },
        { name: 'Certificates', href: route('teacher.certificates'), icon: Trophy, current: route().current('teacher.certificates') },

        { group: 'Account' },
        { name: 'Profile', href: route('teacher.profile'), icon: User, current: route().current('teacher.profile*') },
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
                    "fixed lg:static inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform transition-transform duration-200 ease-in-out lg:transform-none flex flex-col shrink-0",
                    sidebarOpen ? "translate-x-0" : "-translate-x-full"
                )}
            >
                {/* Logo */}
                <div className="h-16 flex items-center px-6 border-b border-gray-200">
                    <span className="text-2xl font-bold text-gray-900 tracking-tight">
                        Imole<span className="text-green-600">.</span>
                    </span>
                    <button 
                        className="ml-auto lg:hidden text-gray-500"
                        onClick={() => setSidebarOpen(false)}
                    >
                        <X size={24} />
                    </button>
                </div>

                {/* Navigation Links */}
                <nav className="flex-1 overflow-y-auto p-4 space-y-1">
                    {navigation.map((item, index) => (
                        item.group ? (
                            <div key={index} className="mt-6 mb-2 px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                {item.group}
                            </div>
                        ) : (
                            <Link
                                key={item.name}
                                href={item.href}
                                className={cn(
                                    "flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors",
                                    item.current 
                                        ? "bg-green-50 text-green-700" 
                                        : "text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                )}
                            >
                                <item.icon className={cn("mr-3 h-5 w-5", item.current ? "text-green-600" : "text-gray-400 group-hover:text-gray-500")} />
                                {item.name}
                            </Link>
                        )
                    ))}
                </nav>

                {/* User Profile / Logout */}
                <div className="border-t border-gray-200 p-4">
                    <Link href={route('teacher.profile')} className="flex items-center mb-4 px-2 hover:bg-gray-50 rounded-lg py-2 -mx-2 transition-colors">
                        {auth.user.avatar_url ? (
                            <img
                                src={auth.user.avatar_url}
                                alt={auth.user.name}
                                className="h-10 w-10 rounded-full object-cover border-2 border-green-200"
                            />
                        ) : (
                            <div className="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold">
                                {auth.user.name.charAt(0).toUpperCase()}
                            </div>
                        )}
                        <div className="ml-3">
                            <p className="text-sm font-medium text-gray-700">{auth.user.name}</p>
                            <p className="text-xs text-gray-500 truncate w-32">{auth.user.headline || auth.user.email}</p>
                        </div>
                    </Link>
                    <Link 
                        href={route('logout')} 
                        method="post" 
                        as="button"
                        className="w-full flex items-center px-3 py-2 text-sm font-medium text-red-600 rounded-md hover:bg-red-50 transition-colors"
                    >
                        <LogOut className="mr-3 h-5 w-5" />
                        Sign Out
                    </Link>
                </div>
            </aside>

            {/* Main Content Area */}
            <div className="flex-1 flex flex-col min-w-0 overflow-hidden">
                {/* Mobile Header */}
                <header className="lg:hidden h-16 bg-white border-b border-gray-200 flex items-center px-4 justify-between">
                    <button 
                        className="text-gray-500 focus:outline-none"
                        onClick={() => setSidebarOpen(true)}
                    >
                        <Menu size={24} />
                    </button>
                    <span className="text-xl font-bold text-gray-900">Imole</span>
                    <div className="w-6" /> {/* Spacer for centering if needed */}
                </header>

                {/* Page Content */}
                <main className="flex-1 overflow-y-auto p-4 lg:p-8">
                    {children}
                </main>
            </div>
        </div>
    );
}
