import React from 'react';
import { Head, router } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Badge } from '../../../components/ui/badge';
import { Bell, Check, CheckCheck, Info, AlertTriangle, AlertCircle } from 'lucide-react';

const typeConfig = {
    info: { label: 'Info', color: 'bg-blue-100 text-blue-700', icon: Info },
    warning: { label: 'Warning', color: 'bg-yellow-100 text-yellow-700', icon: AlertTriangle },
    urgent: { label: 'Urgent', color: 'bg-red-100 text-red-700', icon: AlertCircle },
};

export default function Index({ notifications, unreadCount }) {
    const markAsRead = (id) => {
        router.post(route('teacher.notifications.read', id), {}, { preserveState: true });
    };

    const markAllAsRead = () => {
        router.post(route('teacher.notifications.read-all'), {}, { preserveState: true });
    };

    return (
        <TeacherLayout>
            <Head title="Notifications" />

            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">Notifications</h1>
                        <p className="mt-1 text-gray-500">
                            Stay updated with platform announcements and updates
                        </p>
                    </div>
                    {unreadCount > 0 && (
                        <Button onClick={markAllAsRead} variant="outline" className="gap-2">
                            <CheckCheck className="h-4 w-4" />
                            Mark all as read
                        </Button>
                    )}
                </div>

                {/* Stats */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <Card className="border-0 shadow-sm bg-white">
                        <CardContent className="p-4">
                            <div className="flex items-center gap-3">
                                <div className="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <Bell className="h-5 w-5 text-gray-600" />
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{notifications.length}</p>
                                    <p className="text-sm text-gray-500">Total Notifications</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                    <Card className="border-0 shadow-sm bg-white">
                        <CardContent className="p-4">
                            <div className="flex items-center gap-3">
                                <div className="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center">
                                    <Bell className="h-5 w-5 text-red-600" />
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{unreadCount}</p>
                                    <p className="text-sm text-gray-500">Unread</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Notifications List */}
                <div className="space-y-4">
                    {notifications.length === 0 ? (
                        <Card className="border-0 shadow-sm bg-white">
                            <CardContent className="p-12 text-center">
                                <Bell className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                                <h3 className="text-lg font-medium text-gray-900">No notifications</h3>
                                <p className="text-gray-500 mt-1">
                                    You're all caught up! Check back later for updates.
                                </p>
                            </CardContent>
                        </Card>
                    ) : (
                        notifications.map((notification) => {
                            const TypeIcon = typeConfig[notification.type]?.icon || Info;
                            return (
                                <Card
                                    key={notification.id}
                                    className={`border-0 shadow-sm transition-all ${
                                        !notification.is_read ? 'bg-green-50 border-l-4 border-l-green-500' : 'bg-white'
                                    }`}
                                >
                                    <CardHeader className="flex flex-row items-start justify-between pb-2">
                                        <div className="flex items-start gap-4">
                                            <div className={`h-10 w-10 rounded-lg flex items-center justify-center ${
                                                notification.type === 'urgent' ? 'bg-red-100' :
                                                notification.type === 'warning' ? 'bg-yellow-100' : 'bg-blue-100'
                                            }`}>
                                                <TypeIcon className={`h-5 w-5 ${
                                                    notification.type === 'urgent' ? 'text-red-600' :
                                                    notification.type === 'warning' ? 'text-yellow-600' : 'text-blue-600'
                                                }`} />
                                            </div>
                                            <div>
                                                <div className="flex flex-wrap items-center gap-2">
                                                    <CardTitle className="text-lg text-gray-900">{notification.title}</CardTitle>
                                                    <Badge className={typeConfig[notification.type]?.color}>
                                                        {typeConfig[notification.type]?.label}
                                                    </Badge>
                                                    {!notification.is_read && (
                                                        <Badge className="bg-green-500 text-white">New</Badge>
                                                    )}
                                                </div>
                                                <p className="text-sm text-gray-500 mt-1">
                                                    From {notification.author} &bull; {notification.created_at_diff}
                                                </p>
                                            </div>
                                        </div>
                                        {!notification.is_read && (
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                onClick={() => markAsRead(notification.id)}
                                                className="gap-1 text-green-600 hover:text-green-700 hover:bg-green-100"
                                            >
                                                <Check className="h-4 w-4" />
                                                Mark read
                                            </Button>
                                        )}
                                    </CardHeader>
                                    <CardContent>
                                        <p className="text-gray-700 whitespace-pre-wrap">{notification.content}</p>
                                    </CardContent>
                                </Card>
                            );
                        })
                    )}
                </div>
            </div>
        </TeacherLayout>
    );
}
