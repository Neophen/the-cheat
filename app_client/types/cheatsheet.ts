export type ICardSize = {
  rows: number;
  cols: number;
};

export type Card = {
  id: string;
  size: ICardSize;
  rows: ICardRow[];
  cheatSheetId?: string;
};

export type ICardRow = {
  id: string;
  type: ICardRowType;
  language?: string;
  value?: string;
};

export type ICardRowType = 'title' | 'code' | 'comment' | 'table' | 'markdown';

export type Tab = {
  name: string;
  value: ICardRowType;
};

export type Preview = 'web' | 'portrait' | 'landscape';

export type ICheatSheet = {
  id: string;
  title: string;
  description?: string;
  tags: string[];
  cards: Card[];
  createdById?: string;
  createdAt?: string;
};

export type ISheet = {
  id: number;
  title: string;
  description: string;
  img?: string;
  views: number;
  upVotes: number;
  downVotes: number;
  likes: number;
  tags: string[];
  keywords: string[];
  theme: string;
  approved?: boolean;
  published?: boolean;
  user?: {
    id: number;
    name: string;
  };
};
