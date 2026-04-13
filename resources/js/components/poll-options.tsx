import { Checkbox } from './ui/checkbox';
import { Label } from './ui/label';
import { RadioGroup } from './ui/radio-group';

export default function PollOptions({
    idMultichoice,
    slug,
    options = [],
    answer = []
}: { slug: string; idMultichoice: boolean, options: PollOptions[], answer: PollAnswers[] }) {
    
    if (idMultichoice) {
        return (
            <>
                {
                    options.map((option: PollOptions, i: number) => (
                        <div className="flex items-center space-x-3" key={option.option_text}>
                            <Checkbox
                                name={`${slug}-${i}`}
                                id={option.option_text}
                                value={option.id}
                                defaultChecked={answer.some((ans: any) => ans.poll_option_id === option.id)}
                                disabled={answer.length > 0}
                            />
                            <Label htmlFor={option.option_text}>{option.option_text}</Label>
                        </div>
                    )
                    )
                }
            </>
        )
    } else {
        return (
            <RadioGroup
                name={`${slug}-0`}
                items={options}
                value={answer[0]?.poll_option_id?.toString()}
                disabled={answer.length > 0}
            />
        )
    }
}
