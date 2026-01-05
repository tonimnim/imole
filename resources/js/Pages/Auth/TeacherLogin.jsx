import React, { useEffect } from 'react';
import { Head, useForm, Link } from '@inertiajs/react';
import { Button } from '../../Components/ui/button';
import { Input } from '../../Components/ui/input';
import { Label } from '../../Components/ui/label';
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '../../Components/ui/card';
import { Loader2, LogIn } from 'lucide-react';

export default function TeacherLogin({ status }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route('teacher.login'));
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-50 p-4">
            <Head title="Teacher Login" />
            
            <Card className="w-full max-w-md shadow-lg border-t-4 border-t-green-600">
                <CardHeader className="space-y-1">
                    <CardTitle className="text-2xl font-bold text-center">Teacher Portal</CardTitle>
                    <CardDescription className="text-center">
                        Welcome back! Please sign in to continue.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    {status && (
                        <div className="mb-4 font-medium text-sm text-green-600">
                            {status}
                        </div>
                    )}

                    <form onSubmit={submit} className="space-y-4">
                        <div className="space-y-2">
                            <Label htmlFor="email">Email</Label>
                            <Input
                                id="email"
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                required
                                autoFocus
                                autoComplete="username"
                                placeholder="teacher@imole.com"
                                className={errors.email ? "border-red-500" : ""}
                            />
                            {errors.email && <p className="text-sm text-red-500">{errors.email}</p>}
                        </div>

                        <div className="space-y-2">
                            <div className="flex items-center justify-between">
                                <Label htmlFor="password">Password</Label>
                                <Link
                                    href={route('password.request')}
                                    className="text-xs text-green-600 hover:underline"
                                >
                                    Forgot password?
                                </Link>
                            </div>
                            <Input
                                id="password"
                                type="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                required
                                autoComplete="current-password"
                                className={errors.password ? "border-red-500" : ""}
                            />
                            {errors.password && <p className="text-sm text-red-500">{errors.password}</p>}
                        </div>

                        <div className="flex items-center space-x-2">
                             <input
                                type="checkbox"
                                id="remember"
                                className="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                                checked={data.remember}
                                onChange={(e) => setData('remember', e.target.checked)}
                            />
                            <Label htmlFor="remember" className="font-normal text-gray-600 cursor-pointer">Remember me</Label>
                        </div>

                        <Button className="w-full bg-green-600 hover:bg-green-700" disabled={processing}>
                            {processing ? (
                                <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                            ) : (
                                <LogIn className="mr-2 h-4 w-4" />
                            )}
                            Sign In
                        </Button>
                    </form>
                </CardContent>
                <CardFooter className="justify-center flex-col space-y-2">
                    <div className="text-sm text-gray-600">
                        Don't have an account? <Link href={route('teacher.register')} className="text-green-600 hover:underline">Register here</Link>
                    </div>
                    <div className="text-xs text-gray-400">
                        <Link href={route('login')} className="hover:text-gray-600">Are you a student? Login here</Link>
                    </div>
                </CardFooter>
            </Card>
        </div>
    );
}
