import { ArrowRight, LockKeyhole, ShieldCheck, Sparkles } from 'lucide-react';
import { FeatureSteps } from '../components/FeatureSteps';
import { SectionHeading } from '../components/SectionHeading';

export function LandingPage() {
  return (
    <section className="space-y-12">
      <div className="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
        <div>
          <p className="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-brand-green">Invitation Landing Page</p>
          <h1 className="max-w-3xl text-4xl font-extrabold tracking-tight text-brand-text sm:text-5xl lg:text-6xl">
            Invite teammates into secure cloud storage with a clean premium onboarding flow.
          </h1>
          <p className="mt-6 max-w-2xl text-lg leading-8 text-brand-secondary">
            Drivault onboarding is designed to feel light, modern, and trustworthy, with simple account activation,
            OTP verification, and app download prompts that work on every screen size.
          </p>
          <div className="mt-8 flex flex-wrap gap-4">
            <button className="ui-button">
              Start Invitation
              <ArrowRight className="ml-2 h-4 w-4" />
            </button>
            <button className="ui-button-secondary">View Onboarding Flow</button>
          </div>
          <div className="mt-8 flex flex-wrap gap-6">
            <div className="inline-flex items-center gap-3 rounded-2xl border border-brand-border bg-white px-4 py-3 shadow-card">
              <ShieldCheck className="h-5 w-5 text-brand-green" />
              <span className="text-sm font-semibold text-brand-text">Secure verification flow</span>
            </div>
            <div className="inline-flex items-center gap-3 rounded-2xl border border-brand-border bg-white px-4 py-3 shadow-card">
              <LockKeyhole className="h-5 w-5 text-brand-green" />
              <span className="text-sm font-semibold text-brand-text">Protected file access</span>
            </div>
          </div>
        </div>

        <div className="ui-card p-6 sm:p-8">
          <div className="rounded-[24px] bg-brand-mint p-6">
            <div className="mb-5 inline-flex items-center gap-2 rounded-full bg-white px-3 py-2 text-sm font-semibold text-brand-text shadow-card">
              <Sparkles className="h-4 w-4 text-brand-green" />
              Premium onboarding
            </div>
            <div className="space-y-4">
              <div className="rounded-3xl bg-white p-5 shadow-card">
                <p className="text-sm font-semibold text-brand-secondary">Invitation Status</p>
                <div className="mt-3 flex items-end justify-between">
                  <div>
                    <p className="text-3xl font-extrabold text-brand-text">Live</p>
                    <p className="mt-1 text-sm text-brand-secondary">Ready for activation</p>
                  </div>
                  <div className="rounded-full bg-brand-mint px-3 py-2 text-sm font-bold text-brand-green">OTP enabled</div>
                </div>
              </div>
              <div className="grid gap-4 sm:grid-cols-2">
                <div className="rounded-3xl bg-white p-5 shadow-card">
                  <p className="text-sm font-semibold text-brand-secondary">Access Model</p>
                  <p className="mt-2 text-xl font-bold text-brand-text">Mobile + Password</p>
                </div>
                <div className="rounded-3xl bg-white p-5 shadow-card">
                  <p className="text-sm font-semibold text-brand-secondary">Referral Benefit</p>
                  <p className="mt-2 text-xl font-bold text-brand-text">Extra Free Storage</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <SectionHeading
        eyebrow="3-Step Flow"
        title="Clean SaaS cards with soft mint highlights."
        description="This section mirrors the premium onboarding rhythm you asked for: a white surface, green connectors, spacious typography, and soft shadows."
      />
      <FeatureSteps />
    </section>
  );
}
