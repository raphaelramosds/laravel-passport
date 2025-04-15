import Link from "next/link";

export default function Login() {
    return ( 
        <div className="container mt-5">
            <div className="jumbotron col-lg-4 offset-lg-4">
                <p className="lead">Please login to your account.</p>
                <hr className="my-4" />
                <form method="POST">
                    <div className="form-group">
                        <label htmlFor="email">Email</label>
                        <input type="email" className="form-control" id="email" name="email" required />
                    </div>
                    <div className="form-group">
                        <label htmlFor="password">Password</label>
                        <input type="password" className="form-control" id="password" name="password" required />
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