export function Brand() {
  return (
    <div className="inline-flex items-center gap-3">
      <div className="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-mint">
        <div className="h-5 w-5 rounded-lg bg-brand-green" />
      </div>
      <div>
        <p className="text-lg font-extrabold tracking-tight text-brand-text">Drivault</p>
        <p className="text-sm font-medium text-brand-secondary">Invitation System</p>
      </div>
    </div>
  );
}
