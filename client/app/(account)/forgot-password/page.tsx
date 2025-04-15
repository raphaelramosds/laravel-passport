import Link from "next/link";

export default function ForgotPassword() {
    return (
        <div className="container mt-5">
            <div className="jumbotron col-lg-4 offset-lg-4">
                <p className="lead">Password recovery</p>
                <hr className="my-4" />
                <form method="POST">
                    <div className="form-group">
                        <label htmlFor="email">Email</label>
                        <input type="email" className="form-control" id="email" name="email" required />
                    </div>
                    <button type="submit" className="btn btn-primary">Send email</button>
                    <div className="mt-3 text-center">
                        <Link className="text-secondary" href="/login">Login</Link>
                    </div>
                </form>
            </div>
        </div>
    );
}