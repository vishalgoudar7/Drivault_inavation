import { CheckCircle2, Clock3 } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { otpDigits } from '../data/placeholders';

function formatTimer(totalSeconds: number) {
  const minutes = Math.floor(totalSeconds / 60);
  const seconds = totalSeconds % 60;
  return `${minutes}:${seconds.toString().padStart(2, '0')}`;
}

export function OtpVerificationPage() {
  const [secondsLeft, setSecondsLeft] = useState(74);
  const [verified, setVerified] = useState(false);

  useEffect(() => {
    if (secondsLeft <= 0 || verified) {
      return;
    }

    const timer = window.setTimeout(() => {
      setSecondsLeft((current) => current - 1);
    }, 1000);

    return () => window.clearTimeout(timer);
  }, [secondsLeft, verified]);

  const statusLabel = useMemo(() => (verified ? 'Verified successfully' : 'Waiting for verification'), [verified]);

  return (
    <section className="grid gap-8 lg:grid-cols-[1fr_440px] lg:items-center">
      <div>
        <p className="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-brand-green">OTP Verification</p>
        <h2 className="text-4xl font-extrabold tracking-tight text-brand-text">Verify the one-time passcode with a focused mint-green success flow.</h2>
        <p className="mt-5 max-w-2xl text-lg leading-8 text-brand-secondary">
          This screen includes segmented OTP boxes, a countdown timer, and a clear success state that feels lightweight and premium.
        </p>
      </div>

      <div className="ui-card mx-auto w-full max-w-[440px] p-8">
        <div className="mb-4 flex items-center justify-between">
          <h3 className="text-2xl font-extrabold text-brand-text">Verify OTP</h3>
          <div className="inline-flex items-center gap-2 rounded-full bg-brand-mint px-3 py-2 text-sm font-semibold text-brand-text">
            <Clock3 className="h-4 w-4 text-brand-green" />
            {formatTimer(secondsLeft)}
          </div>
        </div>
        <p className="text-sm leading-7 text-brand-secondary">
          Enter the code sent to your mobile number to activate secure access.
        </p>

        <div className="mt-8 grid grid-cols-6 gap-3">
          {otpDigits.map((digit, index) => (
            <div
              key={`${digit}-${index}`}
              className={`flex h-14 items-center justify-center rounded-2xl border text-lg font-bold transition ${
                verified
                  ? 'border-brand-green bg-brand-mint text-brand-text'
                  : 'border-brand-border bg-white text-brand-text'
              }`}
            >
              {digit}
            </div>
          ))}
        </div>

        <button
          type="button"
          className="ui-button mt-8 w-full"
          onClick={() => {
            setVerified(true);
          }}
        >
          Verify Code
        </button>

        <div
          className={`mt-5 flex items-center gap-3 rounded-2xl border px-4 py-3 text-sm font-medium transition ${
            verified
              ? 'border-brand-green bg-brand-mint text-brand-text'
              : 'border-brand-border bg-white text-brand-secondary'
          }`}
        >
          <CheckCircle2 className={`h-5 w-5 transition ${verified ? 'scale-110 text-brand-green' : 'text-brand-secondary'}`} />
          {statusLabel}
        </div>
      </div>
    </section>
  );
}
