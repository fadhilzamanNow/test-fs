// src/lib/planLogs.ts
import { startLoading, stopLoading } from '../store/loading';
import http from './axios'
import type { PlanLog } from './utils';


export async function getAllPlanLogs(perPage: number, page: number, q = '') {
  try {
    startLoading()
    const { data } = await http.get('/plan-logs', {
      params: { perPage, page, q },
    })
    return data as { data: PlanLog[]; total: number }
  } catch (err: any) {
    throw new Error(err?.response?.data?.message ?? 'Gagal mengambil plan logs')
  } finally {
    stopLoading()
  }
}
