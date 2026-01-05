import React, { useState, useRef } from 'react';
import { Head, router, usePage } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent, CardDescription } from '../../../components/ui/card';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { Input } from '../../../components/ui/input';
import { Label } from '../../../components/ui/label';
import {
    User, Camera, MapPin, Link as LinkIcon, Twitter, Linkedin, Youtube, Phone, Mail,
    BookOpen, Users, Star, GraduationCap, Calendar, Edit2, Save, X, Plus, Trash2, Globe
} from 'lucide-react';

export default function ProfileIndex({ profile, stats, recentCourses }) {
    const { flash } = usePage().props;
    const [isEditing, setIsEditing] = useState(false);
    const [processing, setProcessing] = useState(false);
    const fileInputRef = useRef(null);

    const [form, setForm] = useState({
        name: profile.name,
        headline: profile.headline || '',
        bio: profile.bio || '',
        expertise: profile.expertise || [],
        website: profile.website || '',
        twitter: profile.twitter || '',
        linkedin: profile.linkedin || '',
        youtube: profile.youtube || '',
        phone: profile.phone || '',
        location: profile.location || '',
    });

    const [newExpertise, setNewExpertise] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        setProcessing(true);
        router.put(route('teacher.profile.update'), form, {
            onSuccess: () => setIsEditing(false),
            onFinish: () => setProcessing(false),
        });
    };

    const handleAvatarChange = (e) => {
        const file = e.target.files?.[0];
        if (file) {
            const formData = new FormData();
            formData.append('avatar', file);
            router.post(route('teacher.profile.avatar'), formData, {
                forceFormData: true,
            });
        }
    };

    const handleRemoveAvatar = () => {
        router.delete(route('teacher.profile.avatar.remove'));
    };

    const addExpertise = () => {
        if (newExpertise.trim() && !form.expertise.includes(newExpertise.trim())) {
            setForm({ ...form, expertise: [...form.expertise, newExpertise.trim()] });
            setNewExpertise('');
        }
    };

    const removeExpertise = (index) => {
        setForm({ ...form, expertise: form.expertise.filter((_, i) => i !== index) });
    };

    return (
        <TeacherLayout>
            <Head title="Profile" />

            {/* Flash Messages */}
            {flash?.success && (
                <div className="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {flash.success}
                </div>
            )}

            {/* Profile Header Card */}
            <Card className="mb-8 overflow-hidden">
                {/* Cover Image */}
                <div className="h-32 bg-gradient-to-r from-green-600 via-green-500 to-emerald-400" />

                <CardContent className="relative pt-0 pb-6">
                    <div className="flex flex-col lg:flex-row gap-6">
                        {/* Avatar Section */}
                        <div className="relative -mt-16 lg:-mt-12">
                            <div className="relative group">
                                <div className="h-32 w-32 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden">
                                    {profile.avatarUrl ? (
                                        <img
                                            src={profile.avatarUrl}
                                            alt={profile.name}
                                            className="h-full w-full object-cover"
                                        />
                                    ) : (
                                        <div className="h-full w-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-4xl font-bold">
                                            {profile.name.charAt(0).toUpperCase()}
                                        </div>
                                    )}
                                </div>
                                <input
                                    ref={fileInputRef}
                                    type="file"
                                    accept="image/*"
                                    onChange={handleAvatarChange}
                                    className="hidden"
                                />
                                <div className="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
                                     onClick={() => fileInputRef.current?.click()}>
                                    <Camera className="h-8 w-8 text-white" />
                                </div>
                            </div>
                            {profile.avatar && (
                                <button
                                    onClick={handleRemoveAvatar}
                                    className="absolute -bottom-1 -right-1 h-8 w-8 bg-red-100 rounded-full flex items-center justify-center text-red-600 hover:bg-red-200 transition-colors"
                                >
                                    <Trash2 className="h-4 w-4" />
                                </button>
                            )}
                        </div>

                        {/* Profile Info */}
                        <div className="flex-1 lg:pt-4">
                            <div className="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <div>
                                    <h1 className="text-2xl font-bold text-gray-900">{profile.name}</h1>
                                    {profile.headline && (
                                        <p className="text-lg text-gray-600 mt-1">{profile.headline}</p>
                                    )}
                                    <div className="flex flex-wrap items-center gap-4 mt-3 text-sm text-gray-500">
                                        {profile.location && (
                                            <span className="flex items-center gap-1">
                                                <MapPin className="h-4 w-4" />
                                                {profile.location}
                                            </span>
                                        )}
                                        <span className="flex items-center gap-1">
                                            <Calendar className="h-4 w-4" />
                                            Joined {profile.joinedAt}
                                        </span>
                                        <span className="flex items-center gap-1">
                                            <Mail className="h-4 w-4" />
                                            {profile.email}
                                        </span>
                                    </div>
                                </div>
                                <Button
                                    onClick={() => setIsEditing(!isEditing)}
                                    variant={isEditing ? 'outline' : 'default'}
                                    className={!isEditing ? 'bg-green-600 hover:bg-green-700' : ''}
                                >
                                    {isEditing ? (
                                        <>
                                            <X className="h-4 w-4 mr-2" />
                                            Cancel
                                        </>
                                    ) : (
                                        <>
                                            <Edit2 className="h-4 w-4 mr-2" />
                                            Edit Profile
                                        </>
                                    )}
                                </Button>
                            </div>

                            {/* Expertise Tags */}
                            {profile.expertise?.length > 0 && (
                                <div className="flex flex-wrap gap-2 mt-4">
                                    {profile.expertise.map((skill, index) => (
                                        <Badge key={index} variant="secondary" className="bg-green-50 text-green-700">
                                            {skill}
                                        </Badge>
                                    ))}
                                </div>
                            )}

                            {/* Social Links */}
                            <div className="flex flex-wrap gap-3 mt-4">
                                {profile.website && (
                                    <a href={profile.website} target="_blank" rel="noopener noreferrer"
                                       className="flex items-center gap-1 text-gray-600 hover:text-green-600 transition-colors">
                                        <Globe className="h-4 w-4" />
                                        <span className="text-sm">Website</span>
                                    </a>
                                )}
                                {profile.twitter && (
                                    <a href={`https://twitter.com/${profile.twitter}`} target="_blank" rel="noopener noreferrer"
                                       className="flex items-center gap-1 text-gray-600 hover:text-blue-400 transition-colors">
                                        <Twitter className="h-4 w-4" />
                                        <span className="text-sm">Twitter</span>
                                    </a>
                                )}
                                {profile.linkedin && (
                                    <a href={profile.linkedin} target="_blank" rel="noopener noreferrer"
                                       className="flex items-center gap-1 text-gray-600 hover:text-blue-600 transition-colors">
                                        <Linkedin className="h-4 w-4" />
                                        <span className="text-sm">LinkedIn</span>
                                    </a>
                                )}
                                {profile.youtube && (
                                    <a href={profile.youtube} target="_blank" rel="noopener noreferrer"
                                       className="flex items-center gap-1 text-gray-600 hover:text-red-600 transition-colors">
                                        <Youtube className="h-4 w-4" />
                                        <span className="text-sm">YouTube</span>
                                    </a>
                                )}
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

            {/* Stats Cards */}
            <div className="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <Card className="text-center">
                    <CardContent className="pt-6">
                        <BookOpen className="h-8 w-8 text-green-600 mx-auto mb-2" />
                        <div className="text-2xl font-bold text-gray-900">{stats.totalCourses}</div>
                        <div className="text-sm text-gray-500">Courses</div>
                    </CardContent>
                </Card>
                <Card className="text-center">
                    <CardContent className="pt-6">
                        <GraduationCap className="h-8 w-8 text-blue-600 mx-auto mb-2" />
                        <div className="text-2xl font-bold text-gray-900">{stats.publishedCourses}</div>
                        <div className="text-sm text-gray-500">Published</div>
                    </CardContent>
                </Card>
                <Card className="text-center">
                    <CardContent className="pt-6">
                        <Users className="h-8 w-8 text-purple-600 mx-auto mb-2" />
                        <div className="text-2xl font-bold text-gray-900">{stats.totalStudents}</div>
                        <div className="text-sm text-gray-500">Students</div>
                    </CardContent>
                </Card>
                <Card className="text-center">
                    <CardContent className="pt-6">
                        <Star className="h-8 w-8 text-yellow-500 mx-auto mb-2" />
                        <div className="text-2xl font-bold text-gray-900">{stats.avgRating}</div>
                        <div className="text-sm text-gray-500">Avg Rating</div>
                    </CardContent>
                </Card>
                <Card className="text-center">
                    <CardContent className="pt-6">
                        <Star className="h-8 w-8 text-amber-500 mx-auto mb-2" />
                        <div className="text-2xl font-bold text-gray-900">{stats.totalReviews}</div>
                        <div className="text-sm text-gray-500">Reviews</div>
                    </CardContent>
                </Card>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {/* Edit Form / Bio */}
                <div className="lg:col-span-2">
                    {isEditing ? (
                        <Card>
                            <CardHeader>
                                <CardTitle>Edit Profile</CardTitle>
                                <CardDescription>Update your public profile information</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <form onSubmit={handleSubmit} className="space-y-6">
                                    {/* Basic Info */}
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <Label htmlFor="name">Full Name</Label>
                                            <Input
                                                id="name"
                                                value={form.name}
                                                onChange={(e) => setForm({ ...form, name: e.target.value })}
                                                required
                                            />
                                        </div>
                                        <div>
                                            <Label htmlFor="headline">Professional Headline</Label>
                                            <Input
                                                id="headline"
                                                value={form.headline}
                                                onChange={(e) => setForm({ ...form, headline: e.target.value })}
                                                placeholder="e.g. Senior Software Engineer | Instructor"
                                            />
                                        </div>
                                    </div>

                                    <div>
                                        <Label htmlFor="bio">Bio</Label>
                                        <textarea
                                            id="bio"
                                            value={form.bio}
                                            onChange={(e) => setForm({ ...form, bio: e.target.value })}
                                            placeholder="Tell students about yourself, your experience, and teaching style..."
                                            rows={5}
                                            className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm resize-none"
                                            maxLength={2000}
                                        />
                                        <p className="text-xs text-gray-500 mt-1">{form.bio.length}/2000 characters</p>
                                    </div>

                                    {/* Expertise */}
                                    <div>
                                        <Label>Areas of Expertise</Label>
                                        <div className="flex flex-wrap gap-2 mb-2">
                                            {form.expertise.map((skill, index) => (
                                                <Badge key={index} variant="secondary" className="bg-green-50 text-green-700 pr-1">
                                                    {skill}
                                                    <button type="button" onClick={() => removeExpertise(index)} className="ml-1 hover:text-red-600">
                                                        <X className="h-3 w-3" />
                                                    </button>
                                                </Badge>
                                            ))}
                                        </div>
                                        <div className="flex gap-2">
                                            <Input
                                                value={newExpertise}
                                                onChange={(e) => setNewExpertise(e.target.value)}
                                                placeholder="Add expertise (e.g. Python, Web Development)"
                                                onKeyPress={(e) => e.key === 'Enter' && (e.preventDefault(), addExpertise())}
                                            />
                                            <Button type="button" variant="outline" onClick={addExpertise}>
                                                <Plus className="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>

                                    {/* Contact & Location */}
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <Label htmlFor="location">Location</Label>
                                            <Input
                                                id="location"
                                                value={form.location}
                                                onChange={(e) => setForm({ ...form, location: e.target.value })}
                                                placeholder="e.g. Lagos, Nigeria"
                                            />
                                        </div>
                                        <div>
                                            <Label htmlFor="phone">Phone (optional)</Label>
                                            <Input
                                                id="phone"
                                                value={form.phone}
                                                onChange={(e) => setForm({ ...form, phone: e.target.value })}
                                                placeholder="+234..."
                                            />
                                        </div>
                                    </div>

                                    {/* Social Links */}
                                    <div className="space-y-4">
                                        <Label className="text-base font-medium">Social Links</Label>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div className="relative">
                                                <Globe className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                                <Input
                                                    value={form.website}
                                                    onChange={(e) => setForm({ ...form, website: e.target.value })}
                                                    placeholder="https://yourwebsite.com"
                                                    className="pl-10"
                                                />
                                            </div>
                                            <div className="relative">
                                                <Twitter className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                                <Input
                                                    value={form.twitter}
                                                    onChange={(e) => setForm({ ...form, twitter: e.target.value })}
                                                    placeholder="username (without @)"
                                                    className="pl-10"
                                                />
                                            </div>
                                            <div className="relative">
                                                <Linkedin className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                                <Input
                                                    value={form.linkedin}
                                                    onChange={(e) => setForm({ ...form, linkedin: e.target.value })}
                                                    placeholder="https://linkedin.com/in/username"
                                                    className="pl-10"
                                                />
                                            </div>
                                            <div className="relative">
                                                <Youtube className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                                                <Input
                                                    value={form.youtube}
                                                    onChange={(e) => setForm({ ...form, youtube: e.target.value })}
                                                    placeholder="https://youtube.com/@channel"
                                                    className="pl-10"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div className="flex justify-end gap-3 pt-4 border-t">
                                        <Button type="button" variant="outline" onClick={() => setIsEditing(false)}>
                                            Cancel
                                        </Button>
                                        <Button type="submit" disabled={processing} className="bg-green-600 hover:bg-green-700">
                                            <Save className="h-4 w-4 mr-2" />
                                            Save Changes
                                        </Button>
                                    </div>
                                </form>
                            </CardContent>
                        </Card>
                    ) : (
                        <Card>
                            <CardHeader>
                                <CardTitle>About</CardTitle>
                            </CardHeader>
                            <CardContent>
                                {profile.bio ? (
                                    <p className="text-gray-600 whitespace-pre-wrap leading-relaxed">{profile.bio}</p>
                                ) : (
                                    <div className="text-center py-8">
                                        <User className="h-12 w-12 text-gray-300 mx-auto mb-3" />
                                        <p className="text-gray-500 mb-4">You haven't added a bio yet.</p>
                                        <Button onClick={() => setIsEditing(true)} variant="outline">
                                            <Edit2 className="h-4 w-4 mr-2" />
                                            Add Bio
                                        </Button>
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    )}
                </div>

                {/* Recent Courses Sidebar */}
                <div>
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                <BookOpen className="h-5 w-5 text-green-600" />
                                Recent Courses
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {recentCourses.length > 0 ? recentCourses.map((course) => (
                                <div key={course.id} className="flex gap-3">
                                    <div className="h-16 w-24 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                                        {course.thumbnailUrl ? (
                                            <img src={course.thumbnailUrl} alt={course.title} className="h-full w-full object-cover" />
                                        ) : (
                                            <div className="h-full w-full flex items-center justify-center">
                                                <BookOpen className="h-6 w-6 text-gray-400" />
                                            </div>
                                        )}
                                    </div>
                                    <div className="flex-1 min-w-0">
                                        <h4 className="font-medium text-gray-900 text-sm line-clamp-2">{course.title}</h4>
                                        <div className="flex items-center gap-3 mt-1 text-xs text-gray-500">
                                            <span className="flex items-center gap-1">
                                                <Users className="h-3 w-3" />
                                                {course.studentsCount}
                                            </span>
                                            <span className="flex items-center gap-1">
                                                <Star className="h-3 w-3 text-yellow-500" />
                                                {course.avgRating || '-'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            )) : (
                                <p className="text-center text-gray-500 py-4">No courses published yet.</p>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </TeacherLayout>
    );
}
