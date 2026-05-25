import { CheckCircle2, Lock } from 'lucide-react';

export function SetPasswordPage() {
  return (
    <section className="grid gap-8 lg:grid-cols-[1fr_420px] lg:items-center">
      <div>
        <p className="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-brand-green">Set Password Page</p>
        <h2 className="text-4xl font-extrabold tracking-tight text-brand-text">Create a password and finish your Drivault access setup.</h2>
        <p className="mt-5 max-w-2xl text-lg leading-8 text-brand-secondary">
          A minimal centered card with secure fields, soft transitions, and clean brand styling for a premium final activation step.
        </p>
      </div>

      <div className="ui-card mx-auto w-full max-w-[420px] p-8">
        <div className="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-mint text-brand-green">
          <Lock className="h-6 w-6" />
        </div>
        <h3 className="text-2xl font-extrabold text-brand-text">Set your password</h3>
        <p className="mt-3 text-sm leading-7 text-brand-secondary">
          Choose a strong password to secure your cloud storage account across web and mobile.
        </p>
        <form className="mt-8 space-y-4">
          <div>
            <label className="mb-2 block text-sm font-semibold text-brand-text">Password</label>
            <input className="ui-input" type="password" placeholder="Create password" />
          </div>
          <div>
            <label className="mb-2 block text-sm font-semibold text-brand-text">Confirm Password</label>
            <input className="ui-input" type="password" placeholder="Confirm password" />
          </div>
          <div className="rounded-2xl bg-brand-mint px-4 py-3 text-sm text-brand-secondary">
            Password should contain at least 8 characters, 1 number, and 1 uppercase letter.
          </div>
          <button type="button" className="ui-button w-full">Activate Account</button>
        </form>
        <div className="mt-6 flex items-center gap-2 text-sm font-medium text-brand-secondary">
          <CheckCircle2 className="h-4 w-4 text-brand-green" />
          Secure form styling with smooth hover and focus transitions
        </div>
      </div>
    </section>
  );
}
