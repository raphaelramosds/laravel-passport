'use client';

import axios from "axios";
import { useEffect, useState } from "react";

export default function Profile() {

    const [user, setUser] = useState<{
        email: string;
        name: string;
    }>({
        email: '',
        name: ''
    });

    useEffect(() => {
        const token = localStorage.getItem('token');

        if (!token) {
            console.warn("No token found");
            return;
        }

        axios.get("http://localhost:89/api/user", {
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`
            }
        })
            .then((response) => {
                setUser({
                    email: response.data.email,
                    name: response.data.name
                });
            })
            .catch((error) => {
                console.error("There was an error fetching the user data!", error);
            });
    }, []);

    return (
        <div className="container mt-5">
            <div className="card mr-auto ml-auto" style={{ width: "18rem" }}>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="size-6">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <div className="card-body">
                    <h5 className="card-title">Hi, {user.name}!</h5>
                    <ul className="list-group">
                        <li className="list-group-item">Email: {user.email}</li>
                    </ul>
                </div>
            </div>
        </div>
    );
}