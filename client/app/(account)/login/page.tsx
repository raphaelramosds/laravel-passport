'use client'

import axios from "axios";

import Link from "next/link";

import { useState } from "react";
import { redirect } from "next/navigation";

export default function Login() {
    
    const [loggedIn, setLoggedIn] = useState(false);
    const [credentials, setCredentials] = useState<{
        email: string;
        password: string;
    }>({
        email: '',
        password: ''
    });

    const handleSubmit = function (event) {
        event.preventDefault();

        const data = {
            email: credentials.email,
            password: credentials.password
        };

        axios.post('http://localhost:89/api/login', data, {
            headers: {
                "Content-Type" : "application/json",
            }
        })
            .then((response) => {
                localStorage.setItem('token', response.data.token);
                setLoggedIn(true);
                alert("Login successful");
            })
            .catch((error) => {
                alert(error.response.data.message);
            });
    }

    if (loggedIn) {
        redirect('/profile');
    }

    return (
        <div className="container mt-5">
            <div className="jumbotron col-lg-4 offset-lg-4">
                <p className="lead">Please login to your account.</p>
                <hr className="my-4" />
                <form method="POST" onSubmit={handleSubmit}>
                    <div className="form-group">
                        <label htmlFor="email">Email</label>
                        <input type="email" className="form-control" id="email" name="email" onChange={(event) => {
                            setCredentials({
                                ...credentials,
                                email: event.target.value
                            });
                        }} />
                    </div>
                    <div className="form-group">
                        <label htmlFor="password">Password</label>
                        <input type="password" className="form-control" id="password" name="password" onChange={(event) => {
                            setCredentials({
                                ...credentials,
                                password: event.target.value
                            });
                        }} />
                    </div>
                    <button type="submit" className="btn btn-primary">Login</button>
                    <div className="mt-3 text-center">
                        <Link href="/forgot-password">Forgot your password?</Link>
                    </div>
                    <div className="mt-3 text-center">
                        <Link className="text-secondary" href="/register">Register</Link>
                    </div>
                </form>
            </div>
        </div>
    );
}