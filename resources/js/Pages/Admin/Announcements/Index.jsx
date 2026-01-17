import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Label } from '../../../components/ui/label';
import { Textarea } from '../../../components/ui/textarea';
import { Badge } from '../../../components/ui/badge';
import {
    Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter,
} from '../../../components/ui/dialog';
import {
    AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent,
    AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle,
} from '../../../components/ui/alert-dialog';
import { Bell, Plus, Edit, Trash2, Eye, EyeOff, Users, AlertTriangle, Info, AlertCircle, Calendar } from 'lucide-react';

const typeConfig = {
    info: { label: 'Info', color: 'bg-blue-100 text-blue-700', icon: Info },
    warning: { label: 'Warning', color: 'bg-yellow-100 text-yellow-700', icon: AlertTriangle },
    urgent: { label: 'Urgent', color: 'bg-red-100 text-red-700', icon: AlertCircle },
};

const audienceConfig = {
    all: { label: 'All Users', color: 'bg-purple-100 text-purple-700' },
    students: { label: 'Students', color: 'bg-green-100 text-green-700' },
    teachers: { label: 'Teachers', color: 'bg-blue-100 text-blue-700' },
};

export default function Index({ announcements, stats, filters }) {
    const [showForm, setShowForm] = useState(false);
    const [editAnnouncement, setEditAnnouncement] = useState(null);
    const [deleteAnnouncement, setDeleteAnnouncement] = useState(null);
    const [formData, setFormData] = useState({
        title: '',
        content: '',
        type: 'info',
        target_audience: 'all',
        is_published: true,
        published_at: '',
        expires_at: '',
    });

    const openCreate = () => {
        setFormData({
            title: '',
            content: '',
            type: 'info',
            target_audience: 'all',
            is_published: true,
            published_at: '',
            expires_at: '',
        });
        setEditAnnouncement(null);
        setShowForm(true);
    };

    const openEdit = (announcement) => {
        setFormData({
            title: announcement.title,
            content: announcement.content,
            type: announcement.type,
            target_audience: announcement.target_audience,
            is_published: announcement.is_published,
            published_at: announcement.published_at || '',
            expires_at: announcement.expires_at || '',
        });
        setEditAnnouncement(announcement);
        setShowForm(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const data = {
            ...formData,
            published_at: formData.published_at || null,
            expires_at: formData.expires_at || null,
        };

        if (editAnnouncement) {
            router.put(route('admin.announcements.update', editAnnouncement.id), data, {
                onSuccess: () => setShowForm(false),
            });
        } else {
            router.post(route('admin.announcements.store'), data, {
                onSuccess: () => setShowForm(false),
            });
        }
    };

    const handleToggle = (announcement) => {
        router.post(route('admin.announcements.toggle', announcement.id), {}, { preserveState: true });
    };

    const handleDelete = () => {
        if (deleteAnnouncement) {
            router.delete(route('admin.announcements.destroy', deleteAnnouncement.id), {
                onSuccess: () => setDeleteAnnouncement(null),
            });
        }
    };

    const handleFilter = (key, value) => {
        router.get(route('admin.announcements.index'), { ...filters, [key]: value || undefined }, {
            preserveState: true,
            replace: true,
        });
    };

    return (
        <AdminLayout>
            <Head title="Announcements" />

            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">Announcements</h1>
                        <p className="mt-1 text-gray-500">Manage platform-wide announcements for users</p>
                    </div>
                    <Button onClick={openCreate} className="bg-amber-500 hover:bg-amber-600">
                        <Plus className="h-4 w-4 mr-2" /> New Announcement
                    </Button>
                </div>

                {/* Stats */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <Card className="border-0 shadow-sm bg-white">
                        <CardContent className="p-4">
                            <div className="flex items-center gap-3">
                                <div className="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                    <Bell className="h-5 w-5 text-gray-600" />
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{stats.total}</p>
                                    <p className="text-sm text-gray-500">Total</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                    <Card className="border-0 shadow-sm bg-white">
                        <CardContent className="p-4">
                            <div className="flex items-center gap-3">
                                <div className="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                                    <Eye className="h-5 w-5 text-green-600" />
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{stats.published}</p>
                                    <p className="text-sm text-gray-500">Published</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                    <Card className="border-0 shadow-sm bg-white">
                        <CardContent className="p-4">
                            <div className="flex items-center gap-3">
                                <div className="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                    <Users className="h-5 w-5 text-amber-600" />
                                </div>
                                <div>
                                    <p className="text-2xl font-bold text-gray-900">{stats.active}</p>
                                    <p className="text-sm text-gray-500">Active Now</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Filters */}
                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-4">
                        <div className="flex flex-wrap gap-4">
                            <div className="flex items-center gap-2">
                                <Label className="text-sm text-gray-600 font-medium">Type:</Label>
                                <select
                                    value={filters.type || ''}
                                    onChange={(e) => handleFilter('type', e.target.value)}
                                    className="border border-gray-300 rounded px-2 py-1 text-sm text-gray-900 bg-white"
                                >
                                    <option value="">All Types</option>
                                    <option value="info">Info</option>
                                    <option value="warning">Warning</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                            <div className="flex items-center gap-2">
                                <Label className="text-sm text-gray-600 font-medium">Audience:</Label>
                                <select
                                    value={filters.audience || ''}
                                    onChange={(e) => handleFilter('audience', e.target.value)}
                                    className="border border-gray-300 rounded px-2 py-1 text-sm text-gray-900 bg-white"
                                >
                                    <option value="">All Audiences</option>
                                    <option value="all">All Users</option>
                                    <option value="students">Students Only</option>
                                    <option value="teachers">Teachers Only</option>
                                </select>
                            </div>
                            <div className="flex items-center gap-2">
                                <Label className="text-sm text-gray-600 font-medium">Status:</Label>
                                <select
                                    value={filters.status || ''}
                                    onChange={(e) => handleFilter('status', e.target.value)}
                                    className="border border-gray-300 rounded px-2 py-1 text-sm text-gray-900 bg-white"
                                >
                                    <option value="">All Status</option>
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Announcements List */}
                <div className="grid gap-4">
                    {announcements.data.length === 0 ? (
                        <Card className="border-0 shadow-sm bg-white">
                            <CardContent className="p-12 text-center">
                                <Bell className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                                <h3 className="text-lg font-medium text-gray-900">No announcements yet</h3>
                                <p className="text-gray-500 mt-1">Create your first announcement to notify users.</p>
                                <Button onClick={openCreate} className="mt-4 bg-amber-500 hover:bg-amber-600 text-white">
                                    <Plus className="h-4 w-4 mr-2" /> Create Announcement
                                </Button>
                            </CardContent>
                        </Card>
                    ) : (
                        announcements.data.map((announcement) => {
                            const TypeIcon = typeConfig[announcement.type]?.icon || Info;
                            return (
                                <Card key={announcement.id} className="border-0 shadow-sm bg-white">
                                    <CardHeader className="flex flex-row items-start justify-between pb-2">
                                        <div className="flex items-start gap-4">
                                            <div className={`h-10 w-10 rounded-lg flex items-center justify-center ${
                                                announcement.type === 'urgent' ? 'bg-red-100' :
                                                announcement.type === 'warning' ? 'bg-yellow-100' : 'bg-blue-100'
                                            }`}>
                                                <TypeIcon className={`h-5 w-5 ${
                                                    announcement.type === 'urgent' ? 'text-red-600' :
                                                    announcement.type === 'warning' ? 'text-yellow-600' : 'text-blue-600'
                                                }`} />
                                            </div>
                                            <div>
                                                <div className="flex flex-wrap items-center gap-2">
                                                    <CardTitle className="text-lg">{announcement.title}</CardTitle>
                                                    <Badge className={typeConfig[announcement.type]?.color}>
                                                        {typeConfig[announcement.type]?.label}
                                                    </Badge>
                                                    <Badge className={audienceConfig[announcement.target_audience]?.color}>
                                                        {audienceConfig[announcement.target_audience]?.label}
                                                    </Badge>
                                                    <Badge className={announcement.is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'}>
                                                        {announcement.is_published ? 'Published' : 'Draft'}
                                                    </Badge>
                                                </div>
                                                <p className="text-sm text-gray-500 mt-1">
                                                    By {announcement.author} • {announcement.created_at}
                                                    {announcement.expires_at && (
                                                        <span className="ml-2 text-orange-600">
                                                            <Calendar className="h-3 w-3 inline mr-1" />
                                                            Expires: {announcement.expires_at}
                                                        </span>
                                                    )}
                                                </p>
                                            </div>
                                        </div>
                                        <div className="flex gap-1">
                                            <Button variant="ghost" size="sm" onClick={() => handleToggle(announcement)}>
                                                {announcement.is_published ? <EyeOff className="h-4 w-4" /> : <Eye className="h-4 w-4" />}
                                            </Button>
                                            <Button variant="ghost" size="sm" onClick={() => openEdit(announcement)}>
                                                <Edit className="h-4 w-4" />
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                className="text-red-600"
                                                onClick={() => setDeleteAnnouncement(announcement)}
                                            >
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </CardHeader>
                                    <CardContent>
                                        <p className="text-gray-700 whitespace-pre-wrap">{announcement.content}</p>
                                    </CardContent>
                                </Card>
                            );
                        })
                    )}
                </div>
            </div>

            {/* Create/Edit Dialog */}
            <Dialog open={showForm} onOpenChange={setShowForm}>
                <DialogContent className="max-w-lg max-h-[90vh] overflow-y-auto bg-white">
                    <DialogHeader>
                        <DialogTitle className="text-gray-900">{editAnnouncement ? 'Edit Announcement' : 'Create Announcement'}</DialogTitle>
                    </DialogHeader>
                    <form onSubmit={handleSubmit} className="space-y-4">
                        <div className="space-y-2">
                            <Label className="text-gray-700 font-medium">Title *</Label>
                            <Input
                                value={formData.title}
                                onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                                placeholder="Announcement title"
                                className="text-gray-900"
                                required
                            />
                        </div>

                        <div className="space-y-2">
                            <Label className="text-gray-700 font-medium">Content *</Label>
                            <Textarea
                                value={formData.content}
                                onChange={(e) => setFormData({ ...formData, content: e.target.value })}
                                placeholder="Write your announcement message..."
                                className="text-gray-900"
                                rows={5}
                                required
                            />
                        </div>

                        <div className="grid grid-cols-2 gap-4">
                            <div className="space-y-2">
                                <Label className="text-gray-700 font-medium">Type *</Label>
                                <select
                                    value={formData.type}
                                    onChange={(e) => setFormData({ ...formData, type: e.target.value })}
                                    className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-900 bg-white"
                                    required
                                >
                                    <option value="info">Info</option>
                                    <option value="warning">Warning</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>

                            <div className="space-y-2">
                                <Label className="text-gray-700 font-medium">Target Audience *</Label>
                                <select
                                    value={formData.target_audience}
                                    onChange={(e) => setFormData({ ...formData, target_audience: e.target.value })}
                                    className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-900 bg-white"
                                    required
                                >
                                    <option value="all">All Users</option>
                                    <option value="students">Students Only</option>
                                    <option value="teachers">Teachers Only</option>
                                </select>
                            </div>
                        </div>

                        <div className="grid grid-cols-2 gap-4">
                            <div className="space-y-2">
                                <Label className="text-gray-700 font-medium">Publish Date (optional)</Label>
                                <Input
                                    type="datetime-local"
                                    value={formData.published_at}
                                    onChange={(e) => setFormData({ ...formData, published_at: e.target.value })}
                                    className="text-gray-900"
                                />
                                <p className="text-xs text-gray-500">Leave empty to publish immediately</p>
                            </div>

                            <div className="space-y-2">
                                <Label className="text-gray-700 font-medium">Expiry Date (optional)</Label>
                                <Input
                                    type="datetime-local"
                                    value={formData.expires_at}
                                    onChange={(e) => setFormData({ ...formData, expires_at: e.target.value })}
                                    className="text-gray-900"
                                />
                                <p className="text-xs text-gray-500">Leave empty for no expiry</p>
                            </div>
                        </div>

                        <div className="flex items-center gap-2">
                            <input
                                type="checkbox"
                                id="is_published"
                                checked={formData.is_published}
                                onChange={(e) => setFormData({ ...formData, is_published: e.target.checked })}
                                className="rounded border-gray-300"
                            />
                            <Label htmlFor="is_published" className="text-gray-700">Publish immediately</Label>
                        </div>

                        <DialogFooter>
                            <Button type="button" variant="outline" onClick={() => setShowForm(false)} className="text-gray-700 border-gray-300">Cancel</Button>
                            <Button type="submit" className="bg-amber-500 hover:bg-amber-600 text-white">
                                {editAnnouncement ? 'Update' : 'Create'}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>

            {/* Delete Confirmation */}
            <AlertDialog open={!!deleteAnnouncement} onOpenChange={() => setDeleteAnnouncement(null)}>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Delete Announcement</AlertDialogTitle>
                        <AlertDialogDescription>
                            Are you sure you want to delete "{deleteAnnouncement?.title}"? This action cannot be undone.
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction onClick={handleDelete} className="bg-red-600 hover:bg-red-700">Delete</AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>
        </AdminLayout>
    );
}
