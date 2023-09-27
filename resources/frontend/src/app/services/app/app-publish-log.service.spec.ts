import { TestBed } from '@angular/core/testing';

import { AppPublishLogService } from './app-publish-log.service';

describe('AppPublishLogService', () => {
  let service: AppPublishLogService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AppPublishLogService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
