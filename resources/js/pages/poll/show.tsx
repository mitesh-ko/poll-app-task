import { Form, Head } from '@inertiajs/react';
import PollOptions from '@/components/poll-options';
import { store } from '@/routes/poll';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { useEffect, useState } from 'react';
import dayjs from 'dayjs';

export default function Show({ poll, ansCount, canAns, answer }: { 
    poll: PollShow; ansCount: number; canAns: boolean, answer: PollAnswers[] }) {

    const [count, setCount] = useState(ansCount);
    const [isEnded, setIsEnded] = useState(dayjs().isAfter(poll.end_at));
    if (typeof window !== 'undefined') {
        window.Echo.channel(poll.slug)
            .listen('PollAnswerAdded', (e: any) => {
                setCount(e.ansCount);
            });
    }

    useEffect(() => {
        const interval = setInterval(() => {
            setIsEnded(dayjs().isAfter(poll.end_at));
        }, 1000); // Check every minute

        return () => clearInterval(interval);
    }, [poll.end_at]);
    return (
        <>
            <Head title="Poll" />
            <div className="max-w-prose mb-10">
                <h2 className="text-2xl font-semibold sm:text-3xl">
                    {poll?.question}
                </h2>
                <div className='mt-1'>Total Answers: {count}</div>
            </div>
            {
                isEnded ?
                    <div className="text-lg font-medium">Poll has ended.</div>
                    :
                    <Form
                        {...store.form(poll.slug)}
                        resetOnSuccess={['password']}
                        className="flex flex-col gap-6"
                    >
                        {({ processing, errors }) => (
                            <>
                            {Object.values(errors)?.map((error) => (
                                <div key={error} className="text-red-500">
                                    {error}
                                </div>
                            ))}
                                <PollOptions
                                    idMultichoice={!!poll.is_multichoice}
                                    options={poll.options}
                                    slug={poll.slug}
                                    answer={answer}
                                />

                                <Button
                                    type="submit"
                                    className="mt-4 w-full"
                                    tabIndex={4}
                                    disabled={processing || !canAns}
                                    data-test="login-button"
                                >
                                    {processing && <Spinner />}
                                    {canAns ? 'Submit' : 'Already Answered'}
                                </Button>
                            </>
                        )}
                    </Form>
            }
            <p className="mt-4 text-sm">
                {dayjs().isAfter(poll.end_at) ? 'End on' : 'Ends on'} <time>{dayjs(poll.end_at).format('DD MMM YYYY HH:mm')}</time>
            </p>
        </>
    );
}