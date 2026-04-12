import { Form, Head } from '@inertiajs/react';
import PollOptions from '@/components/poll-options';
import { store } from '@/routes/poll';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { useState } from 'react';

export default function Show({ poll, ansCount, canAns, answer }: any) {
    const [count, setCount] = useState(ansCount);
    window.Echo.channel(poll.slug)
        .listen('PollAnswerAdded', (e: any) => {
            setCount(e.ansCount);
        });

    return (
        <>
            <Head title="Poll" />
            <div className="max-w-prose mb-10">
                <h2 className="text-2xl font-semibold sm:text-3xl">
                    {poll?.question}
                </h2>
                <div className='mt-1'>Total Answers: {count}</div>
            </div>
            <Form
                {...store.form(poll.slug)}
                resetOnSuccess={['password']}
                className="flex flex-col gap-6"
            >
                {({ processing }) => (
                    <>
                        <PollOptions
                            idMultichoice={poll.is_multichoice}
                            options={poll.options}
                            slug={poll.slug}
                            answer={answer}
                        />

                        <Button
                            type="submit"
                            className="mt-4 w-full"
                            tabIndex={4}
                            disabled={processing || canAns}
                            data-test="login-button"
                        >
                            {processing && <Spinner />}
                            {canAns ? 'Already Answered' : 'Submit'}
                        </Button>
                    </>
                )}
            </Form>
            <p className="mt-4 text-sm">
                Ends on <time>{poll.end_at}</time>
            </p>
        </>
    );
}