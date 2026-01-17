import React, { useState } from 'react';
import { Head, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { Card, CardContent, CardHeader, CardTitle } from '../../../components/ui/card';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Label } from '../../../components/ui/label';
import { Badge } from '../../../components/ui/badge';
import {
    Table, TableBody, TableCell, TableHead, TableHeader, TableRow,
} from '../../../components/ui/table';
import {
    Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter,
} from '../../../components/ui/dialog';
import {
    AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent,
    AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle,
} from '../../../components/ui/alert-dialog';
import { FolderTree, Plus, Edit, Trash2 } from 'lucide-react';

export default function Index({ categories }) {
    const [showForm, setShowForm] = useState(false);
    const [editCategory, setEditCategory] = useState(null);
    const [deleteCategory, setDeleteCategory] = useState(null);
    const [formData, setFormData] = useState({ name: '', description: '', icon: '' });

    const openCreate = () => {
        setFormData({ name: '', description: '', icon: '' });
        setEditCategory(null);
        setShowForm(true);
    };

    const openEdit = (category) => {
        setFormData({ name: category.name, description: category.description || '', icon: category.icon || '' });
        setEditCategory(category);
        setShowForm(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (editCategory) {
            router.put(route('admin.categories.update', editCategory.id), formData, {
                onSuccess: () => setShowForm(false),
            });
        } else {
            router.post(route('admin.categories.store'), formData, {
                onSuccess: () => setShowForm(false),
            });
        }
    };

    const handleDelete = () => {
        if (deleteCategory) {
            router.delete(route('admin.categories.destroy', deleteCategory.id), {
                onSuccess: () => setDeleteCategory(null),
            });
        }
    };

    return (
        <AdminLayout>
            <Head title="Categories Management" />

            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">Categories</h1>
                        <p className="mt-1 text-gray-500">Manage course categories</p>
                    </div>
                    <Button onClick={openCreate} className="bg-amber-500 hover:bg-amber-600">
                        <Plus className="h-4 w-4 mr-2" /> Add Category
                    </Button>
                </div>

                <Card className="border-0 shadow-sm bg-white">
                    <CardContent className="p-0">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Description</TableHead>
                                    <TableHead>Courses</TableHead>
                                    <TableHead>Created</TableHead>
                                    <TableHead className="text-right">Actions</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {categories.data.map((category) => (
                                    <TableRow key={category.id}>
                                        <TableCell>
                                            <div className="flex items-center gap-3">
                                                <div className="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center">
                                                    <FolderTree className="h-5 w-5 text-amber-600" />
                                                </div>
                                                <span className="font-medium">{category.name}</span>
                                            </div>
                                        </TableCell>
                                        <TableCell className="text-gray-500 max-w-xs truncate">
                                            {category.description || '-'}
                                        </TableCell>
                                        <TableCell>
                                            <Badge variant="secondary">{category.courses_count} courses</Badge>
                                        </TableCell>
                                        <TableCell className="text-gray-500">{category.created_at}</TableCell>
                                        <TableCell className="text-right">
                                            <Button variant="ghost" size="sm" onClick={() => openEdit(category)}>
                                                <Edit className="h-4 w-4" />
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                className="text-red-600 hover:text-red-700"
                                                onClick={() => setDeleteCategory(category)}
                                            >
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>

            <Dialog open={showForm} onOpenChange={setShowForm}>
                <DialogContent className="bg-white">
                    <DialogHeader>
                        <DialogTitle className="text-gray-900">{editCategory ? 'Edit Category' : 'Create Category'}</DialogTitle>
                    </DialogHeader>
                    <form onSubmit={handleSubmit} className="space-y-4">
                        <div className="space-y-2">
                            <Label className="text-gray-700 font-medium">Name</Label>
                            <Input
                                value={formData.name}
                                onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                                placeholder="Category name"
                                className="text-gray-900"
                                required
                            />
                        </div>
                        <div className="space-y-2">
                            <Label className="text-gray-700 font-medium">Description</Label>
                            <Input
                                value={formData.description}
                                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                                placeholder="Optional description"
                                className="text-gray-900"
                            />
                        </div>
                        <DialogFooter>
                            <Button type="button" variant="outline" onClick={() => setShowForm(false)} className="text-gray-700 border-gray-300">Cancel</Button>
                            <Button type="submit" className="bg-amber-500 hover:bg-amber-600 text-white">
                                {editCategory ? 'Update' : 'Create'}
                            </Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>

            <AlertDialog open={!!deleteCategory} onOpenChange={() => setDeleteCategory(null)}>
                <AlertDialogContent className="bg-white">
                    <AlertDialogHeader>
                        <AlertDialogTitle className="text-gray-900">Delete Category</AlertDialogTitle>
                        <AlertDialogDescription>
                            Are you sure you want to delete "{deleteCategory?.name}"? This cannot be undone.
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
