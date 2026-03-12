import React, {useCallback } from 'react';
import { addUniqueItem, removeItemById } from '@/app/shared/helpers';

interface useMultiSelectProps<T extends { id: number }> {
  items?: T[];
  setItems: (items: T[]) => void;
}
export function useMultiSelect<T extends { id: number }>({
  items = [],
   setItems 
  }: useMultiSelectProps<T>) {
  const addItem = useCallback((item: T) => {
    setItems(addUniqueItem(item, items));
  }, [items, setItems]);

  const removeItem = useCallback((id: number) => {
    setItems(removeItemById(id, items));
  }, [items, setItems]);

  const clearItems = useCallback(() => {
    setItems([]);
  }, [setItems]);

  return {
    items,
    addItem,
    removeItem,
    clearItems,
    setItems,
  };
}