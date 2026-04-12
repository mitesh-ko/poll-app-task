import * as RadioGroupPrimitive from "@radix-ui/react-radio-group"
import { CheckIcon, CircleIcon } from "lucide-react"
import * as React from "react"

import { cn } from "@/lib/utils"
import { Label } from "./label"

function RadioGroup({
  className,
  ...props
}: React.ComponentProps<typeof RadioGroupPrimitive.Root> | any) {
  return (
    <RadioGroupPrimitive.Root
      data-slot="radio"
      className={cn(
        "peer border-input data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground data-[state=checked]:border-primary focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive size-4 shrink-0 rounded-full border shadow-xs transition-shadow outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50",
        className
      )}
      {...props}
    >
      {
        props.items.map((item: any) => (
          <div className="w-5" key={item.option_text}>
            <RadioGroupPrimitive.Item id={item.option_text} value={item.id}>
              <RadioGroupPrimitive.Indicator
                data-slot="checkbox-indicator"
                className="flex items-center justify-center text-current transition-none"
              >
                <CircleIcon fill="black" className="size-3.5" />
              </RadioGroupPrimitive.Indicator>
            </RadioGroupPrimitive.Item>
            <Label htmlFor={item.option_text}>{item.option_text}</Label>
          </div>
        ))
      }

    </RadioGroupPrimitive.Root>
  )
}

export { RadioGroup }
