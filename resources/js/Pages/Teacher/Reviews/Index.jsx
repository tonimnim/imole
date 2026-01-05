import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import TeacherLayout from '../../../Layouts/TeacherLayout';
import { Card, CardHeader, CardTitle, CardContent } from '../../../components/ui/card';
import { Badge } from '../../../components/ui/badge';
import { Button } from '../../../components/ui/button';
import { Star, MessageSquare, ThumbsUp, Filter } from 'lucide-react';

const StarRating = ({ rating, size = 'md' }) => {
    const sizeClasses = {
        sm: 'h-3 w-3',
        md: 'h-4 w-4',
        lg: 'h-5 w-5',
    };

    return (
        <div className="flex gap-0.5">
            {[1, 2, 3, 4, 5].map((star) => (
                <Star
                    key={star}
                    className={`${sizeClasses[size]} ${star <= rating ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300'}`}
                />
            ))}
        </div>
    );
};

export default function ReviewsIndex({ reviews, stats, courses, filters }) {
    const handleFilterChange = (key, value) => {
        router.get(route('teacher.reviews'), {
            ...filters,
            [key]: value || undefined,
        }, { preserveState: true });
    };

    return (
        <TeacherLayout>
            <Head title="Reviews" />

            {/* Header */}
            <div className="flex items-center justify-between mb-8">
                <div>
                    <h1 className="text-3xl font-bold text-gray-900">Reviews</h1>
                    <p className="mt-1 text-gray-500">Student feedback on your courses.</p>
                </div>
            </div>

            {/* Stats with Rating Distribution */}
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                {/* Overall Stats */}
                <Card className="lg:col-span-1">
                    <CardContent className="pt-6">
                        <div className="text-center">
                            <div className="text-5xl font-bold text-gray-900 mb-2">{stats.avgRating}</div>
                            <StarRating rating={Math.round(stats.avgRating)} size="lg" />
                            <div className="text-gray-500 mt-2">{stats.total} total reviews</div>
                        </div>
                    </CardContent>
                </Card>

                {/* Rating Distribution */}
                <Card className="lg:col-span-2">
                    <CardHeader>
                        <CardTitle className="text-sm font-medium text-gray-500">Rating Distribution</CardTitle>
                    </CardHeader>
                    <CardContent className="space-y-3">
                        {[5, 4, 3, 2, 1].map((rating) => {
                            const count = stats.distribution[rating] || 0;
                            const percentage = stats.total > 0 ? (count / stats.total) * 100 : 0;
                            return (
                                <div key={rating} className="flex items-center gap-3">
                                    <button
                                        onClick={() => handleFilterChange('rating', filters.rating == rating ? null : rating)}
                                        className={`flex items-center gap-1 text-sm font-medium min-w-[60px] ${
                                            filters.rating == rating ? 'text-yellow-600' : 'text-gray-600'
                                        } hover:text-yellow-600 transition-colors`}
                                    >
                                        {rating} <Star className="h-3 w-3 fill-current" />
                                    </button>
                                    <div className="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div
                                            className="h-full bg-yellow-400 rounded-full transition-all"
                                            style={{ width: `${percentage}%` }}
                                        />
                                    </div>
                                    <span className="text-sm text-gray-500 min-w-[40px] text-right">{count}</span>
                                </div>
                            );
                        })}
                    </CardContent>
                </Card>
            </div>

            {/* Filters */}
            <Card className="mb-6">
                <CardContent className="pt-6">
                    <div className="flex flex-wrap gap-4 items-center">
                        <div className="flex items-center gap-2">
                            <Filter className="h-4 w-4 text-gray-400" />
                            <span className="text-sm font-medium text-gray-700">Filter by:</span>
                        </div>
                        <select
                            value={filters.course_id || ''}
                            onChange={(e) => handleFilterChange('course_id', e.target.value)}
                            className="border border-gray-300 rounded-lg px-3 py-2 text-sm"
                        >
                            <option value="">All Courses</option>
                            {courses.map((course) => (
                                <option key={course.id} value={course.id}>{course.title}</option>
                            ))}
                        </select>
                        {(filters.course_id || filters.rating) && (
                            <Button
                                variant="ghost"
                                size="sm"
                                onClick={() => router.get(route('teacher.reviews'))}
                            >
                                Clear filters
                            </Button>
                        )}
                    </div>
                </CardContent>
            </Card>

            {/* Reviews List */}
            <div className="space-y-4">
                {reviews.data.length > 0 ? reviews.data.map((review) => (
                    <Card key={review.id} className="hover:shadow-md transition-shadow">
                        <CardContent className="p-6">
                            <div className="flex items-start gap-4">
                                {/* Avatar */}
                                {review.student.avatarUrl ? (
                                    <img src={review.student.avatarUrl} alt={review.student.name} className="h-12 w-12 rounded-full object-cover shrink-0" />
                                ) : (
                                    <div className="h-12 w-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-lg font-bold shrink-0">
                                        {review.student.name.charAt(0).toUpperCase()}
                                    </div>
                                )}

                                {/* Content */}
                                <div className="flex-1 min-w-0">
                                    <div className="flex items-center justify-between mb-2">
                                        <div>
                                            <h3 className="font-semibold text-gray-900">{review.student.name}</h3>
                                            <div className="flex items-center gap-2 text-sm text-gray-500">
                                                <span>{review.course.title}</span>
                                                <span className="text-gray-300">|</span>
                                                <span>{review.timeAgo}</span>
                                            </div>
                                        </div>
                                        <div className="flex items-center gap-3">
                                            <StarRating rating={review.rating} />
                                            {!review.isApproved && (
                                                <Badge variant="secondary" className="bg-yellow-50 text-yellow-700">
                                                    Pending
                                                </Badge>
                                            )}
                                        </div>
                                    </div>

                                    {review.title && (
                                        <h4 className="font-medium text-gray-900 mb-1">{review.title}</h4>
                                    )}
                                    <p className="text-gray-600 leading-relaxed">{review.comment}</p>

                                    {review.helpfulCount > 0 && (
                                        <div className="flex items-center gap-1 mt-3 text-sm text-gray-500">
                                            <ThumbsUp className="h-4 w-4" />
                                            <span>{review.helpfulCount} found this helpful</span>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                )) : (
                    <Card>
                        <CardContent className="py-12 text-center">
                            <MessageSquare className="h-12 w-12 text-gray-300 mx-auto mb-4" />
                            <h3 className="text-lg font-medium text-gray-900 mb-1">No reviews yet</h3>
                            <p className="text-gray-500">Reviews from your students will appear here.</p>
                        </CardContent>
                    </Card>
                )}
            </div>

            {/* Pagination */}
            {reviews.last_page > 1 && (
                <div className="mt-6 flex justify-center gap-2">
                    {reviews.links.map((link, index) => (
                        <Link
                            key={index}
                            href={link.url || '#'}
                            className={`px-4 py-2 rounded-lg text-sm font-medium transition-colors ${
                                link.active
                                    ? 'bg-green-600 text-white'
                                    : link.url
                                    ? 'bg-white text-gray-700 hover:bg-gray-50 border'
                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                            }`}
                            dangerouslySetInnerHTML={{ __html: link.label }}
                        />
                    ))}
                </div>
            )}
        </TeacherLayout>
    );
}
