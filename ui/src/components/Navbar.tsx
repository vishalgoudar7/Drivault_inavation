import { Brand } from './Brand';

type NavbarProps = {
  currentLabel: string;
};

export function Navbar({ currentLabel }: NavbarProps) {
  return (
    <header className="ui-shell pt-6">
      <div className="flex flex-col gap-5 rounded-[28px] border border-brand-border bg-white/80 px-6 py-5 shadow-soft backdrop-blur md:flex-row md:items-center md:justify-between">
        <Brand />
        <nav className="flex flex-wrap items-center gap-3 text-sm font-semibold text-brand-secondary">
          <span className="rounded-full bg-brand-mint px-4 py-2 text-brand-text">{currentLabel}</span>
          <span>Secure Storage</span>
          <span>Mobile Onboarding</span>
          <span>Referral Growth</span>
        </nav>
      </div>
    </header>
  );
}
