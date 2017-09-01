import React, { Component } from 'react';
import { Page, Banner } from '@shopify/polaris';

class Dashboard extends Component
{
    render() {
        return (
          <Page>
              <Banner
                title="Missing Apparel21 connection details"
                action={{content: 'Provide details', onAction: function () { window.history.push('/foo') }}}
              >
                  <p>In order to communicate with Apparel21, we need a few details from you.</p>
              </Banner>
          </Page>
        );
    }
}

export default Dashboard;