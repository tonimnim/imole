import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardContent } from '../../../components/ui/card';
import { Input } from '../../../components/ui/input';
import { Label } from '../../../components/ui/label';
import { Textarea } from '../../../components/ui/textarea';
import { Button } from '../../../components/ui/button';
import { Checkbox } from '../../../components/ui/checkbox';
import { ArrowLeft, Loader2, Save } from 'lucide-react';

export default function CreateCourse({ categories }) {
    const [processing, setProcessing] = useState(false);
    const [errors, setErrors] = useState({});
    const [data, setFormData] = useState({
        title: '',
        subtitle: '',
        description: '',
        category_id: '',
        level: 'beginner',
        language: 'English',
        objectives: '',
        requirements: '',
        price: '',
        discount_price: '',
        has_certificate: false,
        allow_reviews: true,
        status: 'draft',
    });

    const setData = (key, value) => {
        setFormData(prev => ({ ...prev, [key]: value }));
    };

    const submit = (e, statusValue) => {
        e.preventDefault();
        setProcessing(true);
        setErrors({});

        router.post(route('teacher.courses.store'), {
            ...data,
            status: statusValue,
        }, {
            preserveScroll: true,
            onSuccess: () => {
                setProcessing(false);
            },
            onError: (validationErrors) => {
                setErrors(validationErrors);
                setProcessing(false);
            },
            onFinish: () => {
                setProcessing(false);
            }
        });
    };

    return (
        <TeacherLayout>
            <Head title="Create New Course" />

            <form> {/* Removed onSubmit here, handled by buttons */}
                {/* Header */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    <div className="flex items-center gap-4">
                        <Link href={route('teacher.courses')} className="p-2 hover:bg-gray-100 rounded-full transition-colors">
                            <ArrowLeft className="h-5 w-5 text-gray-500" />
                        </Link>
                        <div>
                            <h1 className="text-2xl font-bold text-gray-900">Create New Course</h1>
                            <p className="text-sm text-gray-500">Fill in the details to get started.</p>
                        </div>
                    </div>
                    <div className="flex items-center gap-3">
                        <Button 
                            type="button" 
                            variant="outline" 
                            disabled={processing}
                            onClick={(e) => submit(e, 'draft')}
                        >
                            Save as Draft
                        </Button>
                        <Button 
                            type="button" 
                            className="bg-green-600 hover:bg-green-700"
                            disabled={processing}
                            onClick={(e) => submit(e, 'published')}
                        >
                            {processing ? <Loader2 className="mr-2 h-4 w-4 animate-spin" /> : <Save className="mr-2 h-4 w-4" />}
                            Publish Course
                        </Button>
                    </div>
                </div>

                {Object.keys(errors).length > 0 && (
                    <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                        <p className="font-bold">Please fix the following errors:</p>
                        <ul className="list-disc list-inside text-sm mt-1">
                            {Object.values(errors).map((error, index) => (
                                <li key={index}>{error}</li>
                            ))}
                        </ul>
                    </div>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {/* Left Column (Main Info) */}
                    <div className="lg:col-span-2 space-y-8">
                        {/* Basic Info */}
                        <section className="space-y-4">
                            <h3 className="text-lg font-semibold text-gray-900">Basic Information</h3>
                            <Card>
                                <CardContent className="p-6 space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="title">Course Title <span className="text-red-500">*</span></Label>
                                        <Input
                                            id="title"
                                            value={data.title}
                                            onChange={e => setData('title', e.target.value)}
                                            placeholder="e.g. Introduction to Web Development"
                                            className={errors.title ? "border-red-500" : ""}
                                        />
                                        {errors.title && <p className="text-sm text-red-500">{errors.title}</p>}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="subtitle">Subtitle</Label>
                                        <Input
                                            id="subtitle"
                                            value={data.subtitle}
                                            onChange={e => setData('subtitle', e.target.value)}
                                            placeholder="A brief tagline for your course"
                                        />
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="description">Description <span className="text-red-500">*</span></Label>
                                        <Textarea
                                            id="description"
                                            rows={5}
                                            value={data.description}
                                            onChange={e => setData('description', e.target.value)}
                                            placeholder="Describe what students will learn..."
                                            className={errors.description ? "border-red-500" : ""}
                                        />
                                        {errors.description && <p className="text-sm text-red-500">{errors.description}</p>}
                                    </div>
                                </CardContent>
                            </Card>
                        </section>

                        {/* Content Details */}
                        <section className="space-y-4">
                            <h3 className="text-lg font-semibold text-gray-900">Course Content</h3>
                            <Card>
                                <CardContent className="p-6 space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="objectives">What will students learn? (Objectives)</Label>
                                        <Textarea
                                            id="objectives"
                                            rows={4}
                                            value={data.objectives}
                                            onChange={e => setData('objectives', e.target.value)}
                                            placeholder="Enter each learning objective on a new line"
                                        />
                                        <p className="text-xs text-gray-500">One objective per line</p>
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="requirements">Requirements / Prerequisites</Label>
                                        <Textarea
                                            id="requirements"
                                            rows={3}
                                            value={data.requirements}
                                            onChange={e => setData('requirements', e.target.value)}
                                            placeholder="What should students know before taking this course?"
                                        />
                                        <p className="text-xs text-gray-500">One requirement per line</p>
                                    </div>
                                </CardContent>
                            </Card>
                        </section>
                    </div>

                    {/* Right Column (Settings & Pricing) */}
                    <div className="space-y-8">
                        {/* Categorization */}
                        <section className="space-y-4">
                            <h3 className="text-lg font-semibold text-gray-900">Categorization</h3>
                            <Card>
                                <CardContent className="p-6 space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="category">Category <span className="text-red-500">*</span></Label>
                                        <select
                                            id="category"
                                            value={data.category_id}
                                            onChange={e => setData('category_id', e.target.value)}
                                            className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                        >
                                            <option value="">Select a category</option>
                                            {categories.map(cat => (
                                                <option key={cat.id} value={cat.id}>{cat.name}</option>
                                            ))}
                                        </select>
                                        {errors.category_id && <p className="text-sm text-red-500">{errors.category_id}</p>}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="level">Level <span className="text-red-500">*</span></Label>
                                        <select
                                            id="level"
                                            value={data.level}
                                            onChange={e => setData('level', e.target.value)}
                                            className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                        >
                                            <option value="beginner">Beginner</option>
                                            <option value="intermediate">Intermediate</option>
                                            <option value="advanced">Advanced</option>
                                        </select>
                                        {errors.level && <p className="text-sm text-red-500">{errors.level}</p>}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="language">Language <span className="text-red-500">*</span></Label>
                                        <select
                                            id="language"
                                            value={data.language}
                                            onChange={e => setData('language', e.target.value)}
                                            className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                                        >
                                            <option value="English">English</option>
                                            <option value="Spanish">Spanish</option>
                                            <option value="French">French</option>
                                        </select>
                                        {errors.language && <p className="text-sm text-red-500">{errors.language}</p>}
                                    </div>
                                </CardContent>
                            </Card>
                        </section>

                        {/* Pricing */}
                        <section className="space-y-4">
                            <h3 className="text-lg font-semibold text-gray-900">Pricing</h3>
                            <Card>
                                <CardContent className="p-6 space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="price">Price (USD)</Label>
                                        <div className="relative">
                                            <span className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                            <Input
                                                id="price"
                                                type="number"
                                                min="0"
                                                step="0.01"
                                                className="pl-8"
                                                placeholder="0.00"
                                                value={data.price}
                                                onChange={e => setData('price', e.target.value)}
                                            />
                                        </div>
                                        <p className="text-xs text-gray-500">Leave empty for free</p>
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="discount_price">Discount Price</Label>
                                        <div className="relative">
                                            <span className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                            <Input
                                                id="discount_price"
                                                type="number"
                                                min="0"
                                                step="0.01"
                                                className="pl-8"
                                                placeholder="0.00"
                                                value={data.discount_price}
                                                onChange={e => setData('discount_price', e.target.value)}
                                            />
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </section>

                        {/* Settings */}
                        <section className="space-y-4">
                            <h3 className="text-lg font-semibold text-gray-900">Settings</h3>
                            <Card>
                                <CardContent className="p-6 space-y-4">
                                    <div className="flex items-center space-x-2">
                                        <Checkbox 
                                            id="has_certificate" 
                                            checked={data.has_certificate}
                                            onCheckedChange={(checked) => setData('has_certificate', checked)}
                                        />
                                        <Label htmlFor="has_certificate" className="font-normal">Award certificate</Label>
                                    </div>

                                    <div className="flex items-center space-x-2">
                                        <Checkbox 
                                            id="allow_reviews" 
                                            checked={data.allow_reviews}
                                            onCheckedChange={(checked) => setData('allow_reviews', checked)}
                                        />
                                        <Label htmlFor="allow_reviews" className="font-normal">Allow reviews</Label>
                                    </div>
                                </CardContent>
                            </Card>
                        </section>
                    </div>
                </div>
            </form>
        </TeacherLayout>
    );
}
