import { useMemo, useState } from 'react';
import { Navbar } from './components/Navbar';
import { EmailTemplateScreen } from './screens/EmailTemplateScreen';
import { LandingPage } from './screens/LandingPage';
import { SetPasswordPage } from './screens/SetPasswordPage';
import { OtpVerificationPage } from './screens/OtpVerificationPage';
import { AppDownloadPage } from './screens/AppDownloadPage';

const screens = [
  { id: 'landing', label: 'Landing Page', component: LandingPage },
  { id: 'email', label: 'Email Template', component: EmailTemplateScreen },
  { id: 'password', label: 'Set Password', component: SetPasswordPage },
  { id: 'otp', label: 'OTP Verification', component: OtpVerificationPage },
  { id: 'download', label: 'App Download', component: AppDownloadPage },
] as const;

export default function App() {
  const [activeScreen, setActiveScreen] = useState<(typeof screens)[number]['id']>('landing');

  const ActiveComponent = useMemo(
    () => screens.find((screen) => screen.id === activeScreen)?.component ?? LandingPage,
    [activeScreen],
  );

  const currentLabel = screens.find((screen) => screen.id === activeScreen)?.label ?? 'Landing Page';

  return (
    <div className="pb-16">
      <Navbar currentLabel={currentLabel} />

      <main className="ui-shell pt-10">
        <div className="mb-8 flex flex-wrap gap-3">
          {screens.map((screen) => (
            <button
              key={screen.id}
              type="button"
              onClick={() => setActiveScreen(screen.id)}
              className={
                activeScreen === screen.id
                  ? 'ui-button'
                  : 'rounded-full border border-brand-border bg-white px-4 py-2 text-sm font-semibold text-brand-secondary transition hover:bg-brand-mint'
              }
            >
              {screen.label}
            </button>
          ))}
        </div>

        <ActiveComponent />

        <section className="mt-16 ui-card p-8">
          <p className="text-sm font-semibold uppercase tracking-[0.2em] text-brand-green">Backend Placeholders</p>
          <h3 className="mt-3 text-2xl font-extrabold text-brand-text">Ready for backend integration.</h3>
          <div className="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            {[
              '{{USER_NAME}}',
              '{{INVITER_NAME}}',
              '{{INVITE_LINK}}',
              '{{OTP_CODE}}',
              '{{DOWNLOAD_ANDROID}}',
              '{{DOWNLOAD_IOS}}',
            ].map((token) => (
              <div key={token} className="rounded-2xl border border-brand-border bg-brand-mint px-4 py-4 text-sm font-semibold text-brand-text">
                {token}
              </div>
            ))}
          </div>
        </section>
      </main>
    </div>
  );
}
