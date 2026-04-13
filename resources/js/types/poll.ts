interface PollOptions {
    id: number,
    poll_id: number,
    option_text: string
}

interface PollShow {
    id: number,
    is_multichoice: number,
    slug: string,
    question: string,
    end_at: string,
    options: [
        {
            id: number,
            poll_id: number,
            option_text: string
        }
    ][]
}

interface PollAnswers {
    poll_option_id: number
    id: number
}