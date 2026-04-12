import { Checkbox } from './ui/checkbox';
import { Label } from './ui/label';
import { RadioGroup } from './ui/radio-group';

export default function PollOptions({
    idMultichoice,
    slug,
    options = []
}: { slug: string; idMultichoice: boolean, options: PollOptions[] }) {
    if (idMultichoice) {
        return (
            <>
                {
                    options.map((option: PollOptions) => (
                        <div className="flex items-center space-x-3" key={option.option_text}>
                            <Checkbox
                                name={option.id.toString()}
                                id={option.option_text}
                                value={option.id}
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
                name={slug}
                items={options}
            />
        )
    }
}
