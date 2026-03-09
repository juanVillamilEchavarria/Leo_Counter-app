import { useState, useCallback } from 'react';
import { addUniqueItem, removeItemById } from '@/app/shared/helpers';

export function useMultiSelect<T extends { id: number }>(initialItems: T[] = []) {
  const [selectedItems, setSelectedItems] = useState<T[]>(initialItems);

  const addItem = useCallback((item: T) => {
    setSelectedItems(prev => addUniqueItem(item, prev));
  }, []);

  const removeItem = useCallback((id: number) => {
    setSelectedItems(prev => removeItemById(id, prev));
  }, []);

  const clearItems = useCallback(() => {
    setSelectedItems([]);
  }, []);

  return {
    selectedItems,
    addItem,
    removeItem,
    clearItems,
    setSelectedItems,
  };
}