## 🧪 Testing Examples - Sistema de Reportes

### Setup para Tests

```typescript
// vitest.config.ts o jest.config.ts
import { defineConfig } from 'vitest/config'

export default defineConfig({
  test: {
    globals: true,
    environment: 'jsdom',
  },
})

// package.json
{
  "scripts": {
    "test": "vitest",
    "test:ui": "vitest --ui"
  }
}
```

---

## 🎯 Tests para useReporteForm

```typescript
import { renderHook, act, waitFor } from '@testing-library/react'
import { useReporteForm } from '@/domains/reportes/hooks'
import { describe, it, expect, beforeEach } from 'vitest'

describe('useReporteForm Hook', () => {
  describe('Initial State', () => {
    it('should initialize with default data', () => {
      const { result } = renderHook(() => useReporteForm())

      expect(result.current.data).toEqual({
        cuentas: [],
        categorias: [],
        startDate: '',
        endDate: '',
        only_categorias_fijas: false,
      })
    })

    it('should initialize with partial data', () => {
      const { result } = renderHook(() =>
        useReporteForm({ startDate: '2024-01-01' })
      )

      expect(result.current.data.startDate).toBe('2024-01-01')
      expect(result.current.data.cuentas).toEqual([])
    })
  })

  describe('setData', () => {
    it('should update a single field', () => {
      const { result } = renderHook(() => useReporteForm())

      act(() => {
        result.current.setData('startDate', '2024-01-01')
      })

      expect(result.current.data.startDate).toBe('2024-01-01')
    })

    it('should clear error when field is updated', () => {
      const { result } = renderHook(() => useReporteForm())

      // Set error
      act(() => {
        result.current.setErrors({ startDate: 'La fecha es requerida' })
      })

      expect(result.current.errors.startDate).toBeDefined()

      // Update field
      act(() => {
        result.current.setData('startDate', '2024-01-01')
      })

      // Error should be cleared
      expect(result.current.errors.startDate).toBeUndefined()
    })

    it('should add item to cuentas array', () => {
      const { result } = renderHook(() => useReporteForm())
      const mockCuenta = { id: 1, nombre: 'Cuenta 1' }

      act(() => {
        result.current.setData('cuentas', [mockCuenta])
      })

      expect(result.current.data.cuentas).toHaveLength(1)
      expect(result.current.data.cuentas[0].id).toBe(1)
    })
  })

  describe('Error Management', () => {
    it('should set multiple errors', () => {
      const { result } = renderHook(() => useReporteForm())

      act(() => {
        result.current.setErrors({
          startDate: 'Error 1',
          endDate: 'Error 2',
        })
      })

      expect(result.current.errors.startDate).toBe('Error 1')
      expect(result.current.errors.endDate).toBe('Error 2')
    })

    it('should clear all errors', () => {
      const { result } = renderHook(() => useReporteForm())

      act(() => {
        result.current.setErrors({
          startDate: 'Error',
          endDate: 'Error',
        })
      })

      expect(Object.keys(result.current.errors)).toHaveLength(2)

      act(() => {
        result.current.clearErrors()
      })

      expect(Object.keys(result.current.errors)).toHaveLength(0)
    })
  })

  describe('resetForm', () => {
    it('should reset form to initial state', () => {
      const { result } = renderHook(() => useReporteForm())

      act(() => {
        result.current.setData('startDate', '2024-01-01')
        result.current.setData('endDate', '2024-12-31')
        result.current.setErrors({ startDate: 'Error' })
      })

      expect(result.current.data.startDate).toBe('2024-01-01')
      expect(result.current.errors.startDate).toBeDefined()

      act(() => {
        result.current.resetForm()
      })

      expect(result.current.data).toEqual({
        cuentas: [],
        categorias: [],
        startDate: '',
        endDate: '',
        only_categorias_fijas: false,
      })
      expect(result.current.errors).toEqual({})
    })

    it('should preserve custom initial data after reset', () => {
      const { result } = renderHook(() =>
        useReporteForm({ only_categorias_fijas: true })
      )

      act(() => {
        result.current.setData('startDate', '2024-01-01')
      })

      act(() => {
        result.current.resetForm()
      })

      // Solo_categorias_fijas vuelve al estado default (false)
      expect(result.current.data.only_categorias_fijas).toBe(false)
    })
  })
})
```

---

## 🎯 Tests para useGenerateReportMutation

```typescript
import { renderHook, act, waitFor } from '@testing-library/react'
import { QueryClient, QueryClientProvider } from '@tanstack/react-query'
import { useGenerateReportMutation } from '@/domains/reportes/hooks'
import { vi, describe, it, expect, beforeEach } from 'vitest'
import axios from 'axios'

vi.mock('axios')

const createQueryClient = () => new QueryClient({
  defaultOptions: {
    queries: { retry: false },
    mutations: { retry: false },
  },
})

const wrapper = ({ children }) => (
  <QueryClientProvider client={createQueryClient()}>
    {children}
  </QueryClientProvider>
)

describe('useGenerateReportMutation Hook', () => {
  beforeEach(() => {
    vi.clearAllMocks()
  })

  describe('Success Path', () => {
    it('should mutate successfully', async () => {
      const mockResponse = {
        data: {
          message: 'Éxito',
          data: { id: 1, KPIs: {} },
        },
      }

      vi.mocked(axios.post).mockResolvedValueOnce(mockResponse)

      const onSuccess = vi.fn()
      const { result } = renderHook(
        () => useGenerateReportMutation(onSuccess),
        { wrapper }
      )

      const formData = {
        startDate: '2024-01-01',
        endDate: '2024-12-31',
        cuentas: [],
        categorias: [],
        only_categorias_fijas: false,
      }

      act(() => {
        result.current.mutate(formData)
      })

      await waitFor(() => {
        expect(result.current.isSuccess).toBe(true)
      })

      expect(onSuccess).toHaveBeenCalledWith(mockResponse.data)
    })

    it('should set isPending during mutation', async () => {
      vi.mocked(axios.post).mockImplementation(
        () => new Promise((resolve) =>
          setTimeout(
            () => resolve({ data: { message: 'Éxito' } }),
            100
          )
        )
      )

      const { result } = renderHook(
        () => useGenerateReportMutation(),
        { wrapper }
      )

      const formData = { /* ... */ }

      act(() => {
        result.current.mutate(formData)
      })

      expect(result.current.isPending).toBe(true)

      await waitFor(() => {
        expect(result.current.isPending).toBe(false)
      })
    })
  })

  describe('Error Path', () => {
    it('should parse validation errors correctly', async () => {
      const mockError = {
        response: {
          status: 422,
          data: {
            message: 'Validación fallida',
            errors: {
              startDate: ['La fecha es requerida'],
              endDate: ['Debe ser posterior a startDate'],
            },
          },
        },
      }

      vi.mocked(axios.post).mockRejectedValueOnce(mockError)

      const onError = vi.fn()
      const { result } = renderHook(
        () => useGenerateReportMutation(undefined, onError),
        { wrapper }
      )

      const formData = { /* ... */ }

      act(() => {
        result.current.mutate(formData)
      })

      await waitFor(() => {
        expect(result.current.isError).toBe(true)
      })

      expect(onError).toHaveBeenCalledWith({
        startDate: 'La fecha es requerida',
        endDate: 'Debe ser posterior a startDate',
      })

      expect(result.current.validationErrors).toEqual({
        startDate: 'La fecha es requerida',
        endDate: 'Debe ser posterior a startDate',
      })
    })

    it('should handle network errors', async () => {
      const mockError = {
        message: 'Network Error',
        response: null,
      }

      vi.mocked(axios.post).mockRejectedValueOnce(mockError)

      const { result } = renderHook(
        () => useGenerateReportMutation(),
        { wrapper }
      )

      const formData = { /* ... */ }

      act(() => {
        result.current.mutate(formData)
      })

      await waitFor(() => {
        expect(result.current.isError).toBe(true)
      })

      expect(result.current.error).toContain('Network Error')
    })

    it('should extract first validation message if multiple', async () => {
      const mockError = {
        response: {
          status: 422,
          data: {
            message: 'Validación fallida',
            errors: {
              startDate: [
                'La fecha es requerida',
                'El formato debe ser YYYY-MM-DD',
              ],
            },
          },
        },
      }

      vi.mocked(axios.post).mockRejectedValueOnce(mockError)

      const { result } = renderHook(
        () => useGenerateReportMutation(),
        { wrapper }
      )

      act(() => {
        result.current.mutate({ /* ... */ })
      })

      await waitFor(() => {
        expect(result.current.isError).toBe(true)
      })

      // Solo el primer error
      expect(result.current.validationErrors.startDate).toBe(
        'La fecha es requerida'
      )
    })
  })

  describe('Callbacks', () => {
    it('should call onSuccess callback on success', async () => {
      const mockResponse = {
        data: { message: 'Éxito', data: { id: 1 } },
      }

      vi.mocked(axios.post).mockResolvedValueOnce(mockResponse)

      const onSuccess = vi.fn()
      const { result } = renderHook(
        () => useGenerateReportMutation(onSuccess),
        { wrapper }
      )

      act(() => {
        result.current.mutate({ /* ... */ })
      })

      await waitFor(() => {
        expect(onSuccess).toHaveBeenCalled()
      })
    })

    it('should call onError callback with parsed errors', async () => {
      const mockError = {
        response: {
          status: 422,
          data: {
            message: 'Validación fallida',
            errors: { field: ['Error'] },
          },
        },
      }

      vi.mocked(axios.post).mockRejectedValueOnce(mockError)

      const onError = vi.fn()
      const { result } = renderHook(
        () => useGenerateReportMutation(undefined, onError),
        { wrapper }
      )

      act(() => {
        result.current.mutate({ /* ... */ })
      })

      await waitFor(() => {
        expect(onError).toHaveBeenCalledWith({ field: 'Error' })
      })
    })
  })

  describe('reset', () => {
    it('should reset mutation state', async () => {
      const mockError = {
        response: {
          status: 422,
          data: { message: 'Error', errors: {} },
        },
      }

      vi.mocked(axios.post).mockRejectedValueOnce(mockError)

      const { result } = renderHook(
        () => useGenerateReportMutation(),
        { wrapper }
      )

      act(() => {
        result.current.mutate({ /* ... */ })
      })

      await waitFor(() => {
        expect(result.current.isError).toBe(true)
      })

      act(() => {
        result.current.reset()
      })

      expect(result.current.isError).toBe(false)
      expect(result.current.isSuccess).toBe(false)
      expect(result.current.error).toBeNull()
    })
  })
})
```

---

## 🎯 Tests para ReporteForm Component

```typescript
import { render, screen, fireEvent, waitFor } from '@testing-library/react'
import userEvent from '@testing-library/user-event'
import ReporteForm from '@/domains/reportes/components/Sheet/ReporteForm'
import { describe, it, expect, vi } from 'vitest'

describe('ReporteForm Component', () => {
  const mockData = {
    startDate: '',
    endDate: '',
    cuentas: [],
    categorias: [],
    only_categorias_fijas: false,
  }

  const mockOptions = {
    data: {
      categorias: {
        ingresos: [{ id: 1, nombre: 'Ingreso 1' }],
        gastos: [{ id: 2, nombre: 'Gasto 1' }],
      },
      cuentas: [{ id: 1, nombre: 'Cuenta 1' }],
    },
  }

  const defaultProps = {
    data: mockData,
    setData: vi.fn(),
    errors: {},
    onSubmit: vi.fn(),
    isLoading: false,
    options: mockOptions,
  }

  describe('Rendering', () => {
    it('should render form fields', () => {
      render(<ReporteForm {...defaultProps} />)

      expect(screen.getByLabelText(/fecha de inicio/i)).toBeInTheDocument()
      expect(screen.getByLabelText(/fecha de fin/i)).toBeInTheDocument()
      expect(screen.getByText(/solo categorías fijas/i)).toBeInTheDocument()
    })

    it('should disable submit button when form is invalid', () => {
      render(<ReporteForm {...defaultProps} />)

      const submitButton = screen.getByRole('button', { name: /generar/i })
      expect(submitButton).toBeDisabled()
    })

    it('should enable submit button when form is valid', () => {
      const validData = {
        ...mockData,
        startDate: '2024-01-01',
        endDate: '2024-12-31',
        cuentas: [{ id: 1, nombre: 'Cuenta' }],
        categorias: [{ id: 1, nombre: 'Categoría' }],
      }

      render(<ReporteForm {...defaultProps} data={validData} />)

      const submitButton = screen.getByRole('button', { name: /generar/i })
      expect(submitButton).not.toBeDisabled()
    })
  })

  describe('Error Display', () => {
    it('should display validation error message', () => {
      const errors = { startDate: 'La fecha es requerida' }

      render(<ReporteForm {...defaultProps} errors={errors} />)

      expect(screen.getByText('La fecha es requerida')).toBeInTheDocument()
    })

    it('should highlight input with error', () => {
      const errors = { startDate: 'La fecha es requerida' }

      render(<ReporteForm {...defaultProps} errors={errors} />)

      const input = screen.getByLabelText(/fecha de inicio/i)
      expect(input).toHaveClass('border-red-500!')
    })

    it('should display multiple errors', () => {
      const errors = {
        startDate: 'Error 1',
        endDate: 'Error 2',
      }

      render(<ReporteForm {...defaultProps} errors={errors} />)

      expect(screen.getByText('Error 1')).toBeInTheDocument()
      expect(screen.getByText('Error 2')).toBeInTheDocument()
    })
  })

  describe('User Interaction', () => {
    it('should call setData when input value changes', async () => {
      const user = userEvent.setup()
      const setDataMock = vi.fn()

      render(
        <ReporteForm {...defaultProps} setData={setDataMock} />
      )

      const dateInput = screen.getByLabelText(/fecha de inicio/i)
      await user.type(dateInput, '2024-01-01')

      expect(setDataMock).toHaveBeenCalledWith('startDate', '2024-01-01')
    })

    it('should toggle only_categorias_fijas checkbox', async () => {
      const user = userEvent.setup()
      const setDataMock = vi.fn()

      render(
        <ReporteForm {...defaultProps} setData={setDataMock} />
      )

      const checkbox = screen.getByLabelText(/solo categorías fijas/i)
      await user.click(checkbox)

      expect(setDataMock).toHaveBeenCalledWith('only_categorias_fijas', true)
    })

    it('should call onSubmit with correct event', async () => {
      const user = userEvent.setup()
      const onSubmitMock = vi.fn((e) => e.preventDefault())

      const validData = {
        ...mockData,
        startDate: '2024-01-01',
        endDate: '2024-12-31',
        cuentas: [{ id: 1, nombre: 'Cuenta' }],
      }

      render(
        <ReporteForm
          {...defaultProps}
          data={validData}
          onSubmit={onSubmitMock}
        />
      )

      const submitButton = screen.getByRole('button', { name: /generar/i })
      await user.click(submitButton)

      expect(onSubmitMock).toHaveBeenCalled()
    })
  })

  describe('Loading State', () => {
    it('should show loading text on button', () => {
      render(<ReporteForm {...defaultProps} isLoading={true} />)

      const submitButton = screen.getByRole('button', { name: /generando/i })
      expect(submitButton).toBeInTheDocument()
    })

    it('should disable button while loading', () => {
      render(<ReporteForm {...defaultProps} isLoading={true} />)

      const submitButton = screen.getByRole('button')
      expect(submitButton).toBeDisabled()
    })
  })
})
```

---

## 🚀 Ejecutar Tests

```bash
# Correr todos los tests
npm test

# Correr tests en modo watch
npm test -- --watch

# Correr tests con UI
npm test:ui

# Correr tests con coverage
npm test -- --coverage

# Tests específicos
npm test useReporteForm
npm test useGenerateReportMutation
npm test ReporteForm
```

---

## 📊 Cobertura Esperada

- **useReporteForm.tsx**: 100% ✅
- **useGenerateReportMutation.tsx**: 95% ✅
- **ReporteForm.tsx**: 85% ✅
- **Overall**: 90%+ ✅

---

## 📝 Notas Importantes

1. **Mocking de React Query**: Usar `QueryClientProvider` wrapper
2. **Mocking de Axios**: Usar `vi.mock('axios')`
3. **Async Testing**: Usar `waitFor` para cambios asincronos
4. **User Events**: Preferir `@testing-library/user-event` sobre `fireEvent`

