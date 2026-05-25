import { Gift, Smartphone, Users } from 'lucide-react';

const steps = [
  {
    label: '01',
    title: 'Get Your Invite',
    description: 'Receive a secure invitation and begin your cloud onboarding flow.',
    icon: Gift,
  },
  {
    label: '02',
    title: 'Sync Your Devices',
    description: 'Verify your identity and continue seamlessly on web and mobile.',
    icon: Smartphone,
  },
  {
    label: '03',
    title: 'Invite & Earn',
    description: 'Share Drivault with others and unlock additional free storage.',
    icon: Users,
  },
];

export function FeatureSteps() {
  return (
    <div className="grid gap-6 lg:grid-cols-3">
      {steps.map((step, index) => {
        const Icon = step.icon;
        return (
          <div key={step.label} className="relative">
            <div className="ui-card h-full p-6">
              <div className="mb-5 inline-flex items-center gap-3">
                <div className="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-mint text-brand-green">
                  <Icon className="h-5 w-5" />
                </div>
                <span className="text-sm font-bold text-brand-green">{step.label}</span>
              </div>
              <h3 className="text-xl font-bold text-brand-text">{step.title}</h3>
              <p className="mt-3 text-sm leading-7 text-brand-secondary">{step.description}</p>
            </div>
            {index < steps.length - 1 ? (
              <div className="absolute right-[-24px] top-11 hidden h-px w-12 bg-brand-green/50 lg:block" />
            ) : null}
          </div>
        );
      })}
    </div>
  );
}
