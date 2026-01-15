export interface Record {
    id: number,
    user_id: number,
    category: Category;
    name: string,
    amount: string,
    note: string | null,
    record_date: string,
    type: RecordType,
    created_at: string,
    updated_at: string
}

export type RecordType = 'income' | 'expense';

export interface Category {
    id: number;
    name: string;
    group: string;
    type: string;
    color: string;
    icon: string;
    created_at: Date;
    updated_at: Date;
}

export type CategoriesByGroup = { [key: string]: Category[] };

export interface DataRecord {
    group: string, categories: DataRecordCategory[], total_amount: number
}

export interface DataRecordCategory {
    category_id: number,
    name: string,
    total_amount: numbr
    icon: string
}
