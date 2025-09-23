import http from "./axios";


export async function getAllProducts(
  itemRows: number,
  currentPage: number,
  search: string = ''
) {
  try {
    const { data } = await http.get('/products/', {
      params: {
        perPage: itemRows,
        page: currentPage,
        q: search,
      },
    })
    return data
  } catch (err: any) {
    console.error('Failed to fetch products:', err)
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil daftar produk')
  }
}


export async function createProduct(payload: {
  sku: string
  name: string
  stock: number
}) {
  try {
    const { data } = await http.post('/products', payload)
    return data
  } catch (err: any) {
    console.error('Failed to create product:', err)
    throw new Error(err?.response?.data?.message ?? 'Gagal membuat produk')
  }
}

export async function getProduct(id: string | number) {
  try {
    const { data } = await http.get(`/products/${id}`)
    return data
  } catch (err: any) {
    console.error('Failed to fetch product:', err)
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil data produk')
  }
}

export async function updateProduct(
  id: string | number,
  payload: Partial<{ sku: string; name: string; stock: number }>
) {
  try {
    const { data } = await http.patch(`/products/${id}`, payload)
    return data
  } catch (err: any) {
    console.error('Failed to update product:', err)
    throw new Error(err?.response?.data?.message ?? 'Gagal memperbarui produk')
  }
}

export async function deleteProduct(id: string | number) {
  try {
    const { data } = await http.delete(`/api/products/${id}`)
    return data
  } catch (err: any) {
    console.error('Failed to delete product:', err)
    throw new Error(err?.response?.data?.message ?? 'Gagal menghapus produk')
  }
}