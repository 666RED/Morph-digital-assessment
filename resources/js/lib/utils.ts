import { InertiaLinkProps } from '@inertiajs/vue3';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url;
}

export function months() {
    return Array.from({ length: 12 }, (_, i) => {
        const date = new Date()
        date.setMonth(i)

        return {
            label: date.toLocaleString('en-US', { month: 'short' }),
            value: `${date.getFullYear()}-${String(i + 1).padStart(2, '0')}`,
        }
    })
}

export function getCurrentYear() {
    return new Date().getFullYear();
}

export function getCurrentMonth() {
    return new Date().getMonth() + 1;
}

export const MONTHS = [
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
]
