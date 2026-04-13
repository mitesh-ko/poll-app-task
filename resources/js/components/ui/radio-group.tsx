import * as RadioGroupPrimitive from "@radix-ui/react-radio-group"
import { CircleIcon } from "lucide-react"
import * as React from "react"

import { cn } from "@/lib/utils"
import { Label } from "./label"

function RadioGroup({
  className,
  items = [],
  value = '',
  ...props
}: React.ComponentProps<typeof RadioGroupPrimitive.Root> & { items?: any[] }) {
  return (
    <RadioGroupPrimitive.Root
      data-slot="radio"
      className={cn("flex flex-col gap-2.5", className)}
      {...props}
      defaultValue={value?.toString()}
    >
      {items.map((item: any) => (
        <div
          key={item.id}
          className="flex items-center space-x-3"
        >
          <RadioGroupPrimitive.Item
            id={item.option_text}
            value={item.id?.toString()}
            disabled={props.disabled}
            className={cn(
              "peer size-4 rounded-full border border-input shadow-xs transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50",
              "data-[state=checked]:border-primary data-[state=checked]:bg-primary"
            )}
          >
            <RadioGroupPrimitive.Indicator className="flex items-center justify-center">
              <CircleIcon fill="currentColor" className="size-2" />
            </RadioGroupPrimitive.Indicator>
          </RadioGroupPrimitive.Item>
          <Label htmlFor={item.option_text}>{item.option_text}</Label>
        </div>
      ))}
    </RadioGroupPrimitive.Root>
  )
}

export { RadioGroup }
