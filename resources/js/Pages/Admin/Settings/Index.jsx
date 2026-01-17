import React from 'react';
import { Head, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Badge } from '../../../components/ui/badge';
import {
    Settings, Server, Database, RefreshCw, Zap, Globe, Mail, Shield
} from 'lucide-react';

export default function Index({ settings, systemInfo }) {
    const handleClearCache = () => {
        if (confirm('Are you sure you want to clear all caches?')) {
            router.post(route('admin.settings.clear-cache'), {}, { preserveState: true });
        }
    };

    const handleOptimize = () => {
        if (confirm('Are you sure you want to optimize the application?')) {
            router.post(route('admin.settings.optimize'), {}, { preserveState: true });
        }
    };

    const settingsItems = [
        { icon: Globe, label: 'App Name', value: settings.app_name },
        { icon: Globe, label: 'App URL', value: settings.app_url },
        { icon: Mail, label: 'Mail From', value: `${settings.mail_from_name} <${settings.mail_from_address}>` },
    ];

    const systemItems = [
        { label: 'PHP Version', value: systemInfo.php_version, badge: true },
        { label: 'Laravel Version', value: systemInfo.laravel_version, badge: true },
        { label: 'Environment', value: systemInfo.environment, badge: true, color: systemInfo.environment === 'production' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' },
        { label: 'Debug Mode', value: systemInfo.debug_mode ? 'Enabled' : 'Disabled', badge: true, color: systemInfo.debug_mode ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' },
        { label: 'Cache Driver', value: systemInfo.cache_driver },
        { label: 'Session Driver', value: systemInfo.session_driver },
        { label: 'Queue Driver', value: systemInfo.queue_driver },
    ];

    return (
        <AdminLayout>
            <Head title="Settings" />

            <div className="space-y-6">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Settings</h1>
                    <p className="mt-1 text-gray-500">System configuration and maintenance</p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <div className="flex items-center gap-3">
                                <div className="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                    <Settings className="h-5 w-5 text-amber-600" />
                                </div>
                                <div>
                                    <CardTitle>Application Settings</CardTitle>
                                    <CardDescription>Core application configuration</CardDescription>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {settingsItems.map((item, index) => (
                                    <div key={index} className="flex items-center justify-between py-2 border-b last:border-0">
                                        <div className="flex items-center gap-3">
                                            <item.icon className="h-4 w-4 text-gray-400" />
                                            <span className="text-sm text-gray-600">{item.label}</span>
                                        </div>
                                        <span className="text-sm font-medium text-gray-900">{item.value}</span>
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="border-0 shadow-sm bg-white">
                        <CardHeader>
                            <div className="flex items-center gap-3">
                                <div className="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <Server className="h-5 w-5 text-blue-600" />
                                </div>
                                <div>
                                    <CardTitle>System Information</CardTitle>
                                    <CardDescription>Server and environment details</CardDescription>
                                </div>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-4">
                                {systemItems.map((item, index) => (
                                    <div key={index} className="flex items-center justify-between py-2 border-b last:border-0">
                                        <span className="text-sm text-gray-600">{item.label}</span>
                                        {item.badge ? (
                                            <Badge className={item.color || 'bg-gray-100 text-gray-700'}>{item.value}</Badge>
                                        ) : (
                                            <span className="text-sm font-medium text-gray-900">{item.value}</span>
                                        )}
                                    </div>
                                ))}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <Card className="border-0 shadow-sm bg-white">
                    <CardHeader>
                        <div className="flex items-center gap-3">
                            <div className="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center">
                                <Database className="h-5 w-5 text-purple-600" />
                            </div>
                            <div>
                                <CardTitle>Maintenance</CardTitle>
                                <CardDescription>System maintenance actions</CardDescription>
                            </div>
                        </div>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div className="p-4 border rounded-lg">
                                <div className="flex items-start gap-3">
                                    <div className="h-10 w-10 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                        <RefreshCw className="h-5 w-5 text-red-600" />
                                    </div>
                                    <div className="flex-1">
                                        <h3 className="font-medium text-gray-900">Clear Cache</h3>
                                        <p className="text-sm text-gray-500 mt-1">
                                            Clear all application caches including config, routes, views, and compiled files.
                                        </p>
                                        <Button
                                            onClick={handleClearCache}
                                            variant="outline"
                                            size="sm"
                                            className="mt-3"
                                        >
                                            <RefreshCw className="h-4 w-4 mr-2" />
                                            Clear Cache
                                        </Button>
                                    </div>
                                </div>
                            </div>

                            <div className="p-4 border rounded-lg">
                                <div className="flex items-start gap-3">
                                    <div className="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                                        <Zap className="h-5 w-5 text-green-600" />
                                    </div>
                                    <div className="flex-1">
                                        <h3 className="font-medium text-gray-900">Optimize Application</h3>
                                        <p className="text-sm text-gray-500 mt-1">
                                            Cache configuration, routes, and views for better performance.
                                        </p>
                                        <Button
                                            onClick={handleOptimize}
                                            variant="outline"
                                            size="sm"
                                            className="mt-3"
                                        >
                                            <Zap className="h-4 w-4 mr-2" />
                                            Optimize
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AdminLayout>
    );
}
