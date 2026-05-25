type SectionHeadingProps = {
  eyebrow: string;
  title: string;
  description: string;
};

export function SectionHeading({ eyebrow, title, description }: SectionHeadingProps) {
  return (
    <div className="max-w-3xl">
      <p className="mb-3 text-sm font-semibold uppercase tracking-[0.2em] text-brand-green">{eyebrow}</p>
      <h2 className="text-3xl font-extrabold tracking-tight text-brand-text sm:text-4xl">{title}</h2>
      <p className="mt-4 text-base leading-8 text-brand-secondary">{description}</p>
    </div>
  );
}
