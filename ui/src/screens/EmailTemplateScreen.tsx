import { invitationPlaceholders } from '../data/placeholders';
import { buildInvitationEmail } from '../email/invitationEmail';
import { SectionHeading } from '../components/SectionHeading';

export function EmailTemplateScreen() {
  const html = buildInvitationEmail(invitationPlaceholders);

  return (
    <section className="space-y-10">
      <SectionHeading
        eyebrow="Invitation Email"
        title="A premium invite email with inline CSS for Gmail and Outlook."
        description="The email uses a green gradient hero, table-based layout, and clean step cards built with inline styles only."
      />
      <div className="ui-card overflow-hidden p-3 sm:p-5">
        <iframe
          title="Invitation Email Preview"
          srcDoc={html}
          className="h-[840px] w-full rounded-[24px] border border-brand-border bg-white"
        />
      </div>
    </section>
  );
}
