import { Apple, Download, Play } from 'lucide-react';

export function AppDownloadPage() {
  return (
    <section className="grid gap-10 lg:grid-cols-[1fr_1fr] lg:items-center">
      <div>
        <p className="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-brand-green">App Download Page</p>
        <h2 className="text-4xl font-extrabold tracking-tight text-brand-text">Download the app and continue your cloud access everywhere.</h2>
        <p className="mt-5 max-w-2xl text-lg leading-8 text-brand-secondary">
          A bright green-and-white download section with clean store buttons, device preview styling, and a mobile-first layout.
        </p>
        <div className="mt-8 flex flex-wrap gap-4">
          <button className="ui-button">
            <Play className="mr-2 h-4 w-4" />
            Google Play
          </button>
          <button className="ui-button-secondary">
            <Apple className="mr-2 h-4 w-4" />
            App Store
          </button>
        </div>
      </div>

      <div className="relative mx-auto w-full max-w-[480px]">
        <div className="absolute inset-8 rounded-[32px] bg-brand-green/20 blur-3xl" />
        <div className="ui-card relative overflow-hidden p-6">
          <div className="rounded-[30px] bg-brand-mint p-6">
            <div className="mx-auto w-full max-w-[240px] rounded-[36px] border border-brand-border bg-white p-4 shadow-soft">
              <div className="mx-auto mb-5 h-1.5 w-20 rounded-full bg-brand-border" />
              <div className="rounded-[24px] bg-brand-mint p-4">
                <div className="mb-4 flex items-center justify-between">
                  <p className="text-sm font-semibold text-brand-secondary">Drivault App</p>
                  <Download className="h-4 w-4 text-brand-green" />
                </div>
                <div className="space-y-3">
                  <div className="rounded-2xl bg-white p-3 shadow-card">
                    <div className="h-2.5 w-20 rounded-full bg-brand-green/30" />
                    <div className="mt-3 h-2.5 w-full rounded-full bg-brand-border" />
                  </div>
                  <div className="rounded-2xl bg-white p-3 shadow-card">
                    <div className="h-2.5 w-16 rounded-full bg-brand-green/30" />
                    <div className="mt-3 h-2.5 w-4/5 rounded-full bg-brand-border" />
                  </div>
                  <div className="rounded-2xl bg-white p-3 shadow-card">
                    <div className="h-2.5 w-24 rounded-full bg-brand-green/30" />
                    <div className="mt-3 h-2.5 w-3/4 rounded-full bg-brand-border" />
                  </div>
                </div>
              </div>
            </div>
            <div className="mt-6 rounded-[24px] border border-brand-border bg-white px-5 py-4 text-center text-sm font-medium text-brand-secondary">
              Seamless onboarding across web, Android, and iPhone.
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
