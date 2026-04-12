import { Form, Head } from '@inertiajs/react';
import { dashboard } from '@/routes';
import PollOptions from '@/components/poll-options';
import { store } from '@/routes/poll';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';

export default function Dashboard({ poll }: any) {
    return (
        <>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="flex items-center gap-4">
                    <h2 className="text-2xl font-bold tracking-tight">Q: {poll?.question}</h2>
                </div>
                <Form
                    {...store.form(poll.slug)}
                    resetOnSuccess={['password']}
                    className="flex flex-col gap-6"
                >
                    {({ processing }) => (
                        <>
                            <PollOptions idMultichoice={poll.is_multichoice} options={poll.options} slug={poll.slug} />

                            <Button
                                type="submit"
                                className="mt-4 w-full"
                                tabIndex={4}
                                disabled={processing}
                                data-test="login-button"
                            >
                                {processing && <Spinner />}
                                Submit
                            </Button>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}

Dashboard.layout = {
    breadcrumbs: [
        {
            title: 'Dashboard',
            href: dashboard(),
        },
        {
            title: 'Poll',
            href: '',
        },
    ],
};
